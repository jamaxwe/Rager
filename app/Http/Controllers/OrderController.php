<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrackingNumberEmail;
use App\Mail\OrderShipped;
use App\Mail\CompleteOrder;
use App\Mail\CancelOrder;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('user.checkout', compact('cart', 'total'));
    }

    public function placeOrder(Request $request)
    {
        try {
            
            $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'mobilenumber' => 'required|string|max:11',
                'address' => 'required|string',
                'city' => 'required|string',
                'barangay' => 'required|string',
                'zipcode' => 'required|string',
                'paymentmethod' => 'required|string|in:COD,Gcash',
                
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'message' => 'nullable|string',
            ]);

            
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/images', $filename);
                $imagePath = 'images/' . $filename;
            }

            // Create a new order instance
            $order = new Order();
            $order->fname = $request->input('fname');
            $order->lname = $request->input('lname');
            $order->email = $request->input('email');
            $order->mobilenumber = $request->input('mobilenumber');
            $order->address = $request->input('address');
            $order->city = $request->input('city');
            $order->barangay = $request->input('barangay');
            $order->zipcode = $request->input('zipcode');
            $order->paymentmethod = $request->input('paymentmethod');
            $order->status = 'pending';
            $order->message = $request->input('message');

            
            if ($imagePath) {
                $order->image = $imagePath;
            }

            
            $order->tracking_no = 'rager' . rand(10000, 99999);

            
            $order->save();

        $cartItems = session('cart', []);

        foreach ($cartItems as $id => $details) {
            if (isset($details['size'], $details['quantity'], $details['price'])) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item' => $details['item_name'],
                    'size' => $details['size'],
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);

                $product = Product::findOrFail($id);
                $product->decrementStock($details['size'], $details['quantity']);
            }
        }
        session()->forget('cart');
        Mail::to($request->input('email'))->send(new TrackingNumberEmail($order));
        return redirect()->route('user.cart')->with('success', 'Order placed successfully! Please check your email for more details.');
    } catch (\Exception $e) {
        dd($e->getMessage());
        Log::error('Order placement failed: ' . $e->getMessage());
        return redirect()->route('user.cart')->with('error', 'Failed to place order. Please try again.');
    }
}

public function trackOrder(Request $request)
{
    $query = Order::query();

    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    $orders = $query->orderBy('id', 'asc')->paginate(10);

    // Attach order items to each order
    foreach ($orders as $order) {
        $order->orderItems = OrderItem::where('order_id', $order->id)->get();
    }

    return view('Admin.trackorder', compact('orders'));
}

    public function orderDetails($id)
{
    $order = Order::findOrFail($id);
    $orderItems = OrderItem::where('order_id', $id)->get();

    return view('Admin.orderdetails', compact('order', 'orderItems'));
}
public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $originalStatus = $order->status; // Save original status for comparison later

        // Update order status
        $order->status = $request->status;
        $order->save();

        try {
            if ($request->status === 'processing') {
                // Process for processing status
                Mail::send(new OrderShipped($order));
            } elseif ($request->status === 'completed') {
                // Process for completed status
                Mail::send(new CompleteOrder($order));
                $this->updateSoldCount($order);
            } elseif ($request->status === 'cancelled') {
                // Revert stock changes
                $order->load('items.product');
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($product) {
                        // Increment stock based on item quantity and size (if applicable)
                        $product->incrementStock($item->size, $item->quantity);
                    } else {
                        Log::error('Product not found for order item ID: ' . $item->id);
                    }
                }
                // Send cancellation email
                Mail::send(new CancelOrder($order));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to update order status: '. $e->getMessage());
            return redirect()->route('Admin.trackorder')->with('error', 'Failed to update order status. Please try again.');
        }

        // If no errors occurred, redirect with success message
        return redirect()->route('Admin.trackorder')->with('success', 'Order status updated successfully.');
    }





protected function decrementSoldCount($product, $quantity)
{
    $product->sold_count -= $quantity;
    $product->save();
}

public function showTrackOrderForm()
    {
        return view('user.trackorderform');
    }
    public function usertrackOrder(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string',
        ]);
    
        $trackingNumber = $request->input('tracking_number');
    
        
        $order = Order::where('tracking_no', $trackingNumber)->first();
    
        if (!$order) {
            
            return view('user.trackorder')->with('error', 'Order not found for tracking number: ' . $trackingNumber);
        }
    
        
        $orderItems = OrderItem::where('order_id', $order->id)->get();
    
        
        return view('user.trackorderform', compact('order', 'orderItems'));
    }
    public function getOrderCount()
    {
        $count = Order::count();
        return $count;
    }
    public function updateSoldCount(Order $order)
{
    $order->load('items.product'); // Ensure the products are loaded with the items

    foreach ($order->items as $item) {
        $product = $item->product;
        if ($product) { // Check if product is not null
            $product->sold += $item->quantity;
            Log::info('Updating sold count for product ID ' . $product->id . ': ' . $product->sold);
            $product->save();
        } else {
            Log::error('Product not found for order item ID: ' . $item->id);
        }
    }
}
public function salesChart(Request $request)
    {
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

        return view('admin.index', compact('labels', 'data', 'aggregation'));
    }


}

