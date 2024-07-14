<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\AdminLog;
use App\Models\Newsletter;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewItemAdded;
class ProductController extends Controller
{
    public function showProfile()
    {
        $user = auth()->user(); // Assuming user is authenticated
        return view('profile', compact('user'));
    }
    public function index(Request $request)
{
    try {
        $aggregation = $request->input('aggregation', 'daily');

        switch ($aggregation) {
            case 'yearly':
                $sales = OrderItem::selectRaw('YEAR(created_at) as period, SUM(price * quantity) as total')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();
                break;
            case 'monthly':
                $sales = OrderItem::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period, SUM(price * quantity) as total')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();
                break;
            case 'daily':
                $sales = OrderItem::selectRaw('DATE(created_at) as period, SUM(price * quantity) as total')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();
                break;
            default:
                $sales = collect();
        }

        $labels = $sales->pluck('period');
        $data = $sales->pluck('total');

        // Calculate total sales
        $totalSales = OrderItem::sum(DB::raw('price * quantity'));

        // Fetch products
        $products = Product::orderBy('id', 'desc')->get();

        // Debugging: Output the product IDs to check order
        foreach ($products as $product) {
            \Log::info('Product ID: ' . $product->id);
        }

        // Fetch all orders in descending order based on creation date
        $orders = Order::orderBy('created_at', 'desc')->get();

        // Pass totalSales, products, and orders to the view
        return view('Admin.index', compact('products', 'totalSales', 'orders', 'labels', 'data', 'aggregation'));
    } catch (\Exception $e) {
        // Handle exceptions if any
        dd($e->getMessage()); // Output the error message for debugging
    }
}



    public function home()
    {
        $topProducts = OrderItem::select('item', \DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('item')
            ->orderBy('total_quantity', 'desc')
            ->take(3) // Change this number to get more or fewer top products
            ->get();

        // Fetch products using item names
        $products = Product::whereIn('item_name', $topProducts->pluck('item'))->get()->keyBy('item_name');

        // Assign the product to the order item based on the item name
        $topProducts->each(function ($orderItem) use ($products) {
            $orderItem->product = $products[$orderItem->item] ?? null;
        });
        $newReleases = Product::orderBy('created_at', 'desc')->take(2)->get();

        return view('home', compact('topProducts', 'products', 'newReleases'));
    }
    public function adminlogs()
    {
        $logs = AdminLog::with('user')->latest()->paginate(20);
        return view('Admin.adminLogs', compact('logs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_name' => 'required|unique:products,item_name',
            'description' => 'required',
            'price' => 'required|numeric',
            'stocks_s' => 'nullable|numeric',
            'stocks_m' => 'nullable|numeric',
            'stocks_l' => 'nullable|numeric',
            'stocks_xl' => 'nullable|numeric',
            'stocks_2xl' => 'nullable|numeric',
            'stocks_3xl' => 'nullable|numeric',
            'category' => 'required',
            'image1' => 'required|mimes:png,jpg,jpeg|max:2048',
            'image2' => 'required|mimes:png,jpg,jpeg|max:2048',
            
        ]);

        if ($request->hasFile('image1')) {
            $file1 = $request->file('image1');
            $filename1 = time() . '_1.' . $file1->getClientOriginalExtension();
            $file1->storeAs('public/images', $filename1);
            $data['image1'] = 'images/' . $filename1;
        }

        if ($request->hasFile('image2')) {
            $file2 = $request->file('image2');
            $filename2 = time() . '_2.' . $file2->getClientOriginalExtension();
            $file2->storeAs('public/images', $filename2);
            $data['image2'] = 'images/' . $filename2;
        }

        $product = Product::create($data);
        AdminLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Product Added',
            'description' => 'Product "' . $product->item_name . '" added by ' . auth()->user()->name,
        ]);

        $subscribers = Newsletter::all();

        foreach ($subscribers as $subscriber) {
            if (!empty($subscriber->email)) {
                Mail::send(new NewItemAdded($product, $subscriber));
            }
        }


        return redirect(route('Admin.index'))->with('success', 'Product Added successfully');
    }

    public function edit(Product $product)
    {
        return view('Admin.edit', ['product' => $product]);
    }

    public function update(Product $product, Request $request)
    {
        $data = $request->validate([
            'item_name' => 'required|unique:products,item_name,' . $product->id,

            'price' => 'required|numeric',
            'stocks_s' => 'nullable|numeric',
            'stocks_m' => 'nullable|numeric',
            'stocks_l' => 'nullable|numeric',
            'stocks_xl' => 'nullable|numeric',


        ]);

        $product->update($data);
        AdminLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Product edited',
            'description' => 'Product "' . $product->item_name . '" was edited by ' . auth()->user()->name,
        ]);
        return redirect(route('Admin.index'))->with('success', 'Product updated successfully');
    }

    public function delete(Product $product)
    {
        $product->delete();
        AdminLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Product deleted',
            'description' => 'Product "' . $product->item_name . '" was deleted by ' . auth()->user()->name,
        ]);
        return redirect('dashboard')->with('success', 'Product deleted successfully');
    }

    public function shop(Request $request)
{
    $category = $request->input('category', 'all');
    $query = Product::query();

    if ($category !== 'all') {
        $query->where('category', $category);
    }

    // Sort products by availability (unavailable products at the bottom)
    // and by the latest created_at timestamp (newest products first)
    $products = $query->orderBy('unavailable', 'asc')
                      ->orderBy('created_at', 'desc')
                      ->paginate(6);

    return view('user.shop', compact('products', 'category'));
}


    public function shopadmin()
    {
        $products = Product::all();
        return view('Admin.shop_admin', ['products' => $products]);
    }

    public function preview(Product $product)
    {
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->where('unavailable', false)
            ->take(4) // Limit the number of related products
            ->get();

        return view('user.preview', ['product' => $product, 'relatedProducts' => $relatedProducts]);
    }
    public function cart(Product $product)
    {
        $cart = session()->get('cart', []);
        return view('user.cart', ['product' => $product]);
    }

    public function addtocart(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            abort(404);
        }

        $size = $request->size;
        $requestedQuantity = $request->quantity;
        $maxStocks = $product->getMaxStocksForSize($size);

        // Retrieve existing cart items
        $cart = session()->get('cart', []);
        $cartKey = $id . '_' . $size; // Unique key combining product ID and size

        // Check if cart item already exists
        if (isset($cart[$cartKey])) {
            // Calculate total quantity including already added quantity
            $totalQuantity = $cart[$cartKey]['quantity'] + $requestedQuantity;

            // Check if total requested quantity exceeds available stock
            if ($totalQuantity > $maxStocks) {
                return redirect()->route('user.preview', ['product' => $product])
                    ->with('error', 'Requested quantity exceeds available stock for size ' . $size);
            }

            // Update quantity in cart
            $cart[$cartKey]['quantity'] = $totalQuantity;
        } else {
            // Validate requested quantity against available stock
            if ($requestedQuantity > $maxStocks) {
                return redirect()->route('user.preview', ['product' => $product])
                    ->with('error', 'Requested quantity exceeds available stock for size ' . $size);
            }

            // Add new item to cart
            $cart[$cartKey] = [
                "item_name" => $product->item_name,
                "quantity" => $requestedQuantity,
                "price" => $product->price,
                "image1" => $product->image1,
                "size" => $size,
                "maxStocks" => $maxStocks
            ];
        }

        // Update cart in session
        session()->put('cart', $cart);

        return redirect()->route('user.preview', ['product' => $product])
            ->with('success', 'Product added to cart successfully!');
    }



    public function cartupdate(Request $request)
    {
        $cart = session('cart', []);

        $id = $request->input('id');
        $quantity = $request->input('quantity');
        $maxStocks = $request->input('maxStocks'); // Ensure maxStocks is passed in the request

        // Validate quantity against maxStocks
        if ($quantity > $maxStocks) {
            return response()->json(['error' => 'Quantity exceeds available stock'], 400);
        }

        // Update cart item
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session(['cart' => $cart]);
            return response()->json(['success' => true], 200);
        }

        return response()->json(['error' => 'Cart item not found'], 404);
    }

    public function cartdelete(Request $request, $id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('user.cart')->with('success', 'Product removed successfully');
        }

        return redirect()->route('user.cart')->with('error', 'Product not found in cart');
    }

    public function rate(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);

        $newRating = $request->input('rating');
        $currentRating = $product->ratings;
        $currentCount = $product->ratings_count;

        // Calculate new average rating
        $updatedRating = ($currentRating * $currentCount + $newRating) / ($currentCount + 1);

        // Update product ratings
        $product->ratings = round($updatedRating, 2);
        $product->ratings_count = $currentCount + 1;
        $product->save();


        return redirect()->route('user.shop')->with('success', 'Thank you for your rating!');
    }
    public function toggleAvailability(Request $request, Product $product)
    {
        // Check the current status and set the opposite
        $product->unavailable = $product->unavailable ? false : true;

        // Save the changes
        $product->save();
        // Log the availability change
        AdminLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Product Availability',
            'description' => 'Product "' . $product->item_name . '" ' . ' Availability changed ' . ' by ' . auth()->user()->name,
        ]);

        // Redirect back to the admin index page
        return redirect()->route('Admin.index')->with('status', 'Product availability updated.');
    }
}
