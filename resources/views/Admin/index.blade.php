<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link href="{{ asset('/css/index.css') }}" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('/logo/R_logo_2.jpg') }}">
    @extends('Admin.layout')
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <nav class="navbar shadow-lg navbar-expand-sm bg-black custom-nav">
        <div class="container">
            <h1>Stockpile</h1>
            <div class="btn-group ms-auto">
                <button class="btn btn-sm custom-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <span class="d-none d-sm-block">
                            @auth
                                @if(auth()->check() && auth()->user()->name)
                                    <span style="color: white">{{ auth()->user()->name }}</span>
                                @else
                                    Welcome, valued user!
                                @endif
                            @endauth
                        </span>
                        <span style="color: white; padding-left:1vh;" class="dropdown-toggle"></span>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" id="targetItems" style="z-index:99999;">
                    <li class="d-flex justify-content-center align-items-center"
                        style="white-space:nowrap; padding: 1vh 6vh;">
                        <i class="ti ti-user-circle icon"> </i>Admin ID: {{ auth()->user()->id }}
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item d-flex justify-content-center align-items-center"
                            style="white-space:nowrap; padding: 1vh 6vh;" href="{{ route('logout') }}">
                            <i class="ti ti-logout-2 icon"> </i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="sticky-navbar">
        <div class="container stk-cont">
            <a class="btn" href="{{ route('Admin.index') }}">
                <li class="{{ request()->routeIs('Admin.index') ? 'active' : '' }}">Dashboard</li>
            </a>
            <a class="btn" href="{{ route('Admin.trackorder') }}">
                <li class="{{ request()->routeIs('Admin.trackorder') ? 'active' : '' }}">Track Order</li>
            </a>
            <a class="btn" href="{{ route('admin.logs') }}">
                <li class="{{ request()->routeIs('admin.logs') ? 'active' : '' }}">Admin Logs</li>
            </a>
            <a class="btn" href="{{ route('catalogs.index') }}" target="_blank">
                <li class="{{ request()->routeIs('catalogs.index') ? 'active' : '' }}">Catalog</li>
            </a>
        </div>
    </div>

    <div class="container widget pt-3">
        <div class="container box-cont d-flex flex-column align-items-center justify-content-center">
            <div class="row box-wrapper mb-2">
                <div class="col-xl-6 col-md-6 mb-2">
                    <div class="card shadow">
                        <div class="card-body d-flex align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Earnings (Monthly)</div>
                                @php
                                    use App\Models\OrderItem;
                                    use Illuminate\Support\Facades\DB;

                                    $totalSales = OrderItem::whereHas('order', function ($query) {
                                        $query->where('status', 'completed'); // Adjust the status value as needed
                                    })->sum(DB::raw('price * quantity'));
                                @endphp
                                <div class="h5 mb-0 font-weight-bold text-gray-800">₱{{$totalSales}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="ti ti-calendar-month"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 mb-2">
                    <div class="card shadow">
                        <div class="card-body d-flex align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Stock</div>
                                @php
                                    use App\Models\Product;

                                    $products = Product::all();
                                    $totalstocks = 0;

                                    foreach ($products as $product) {
                                        $totalstocks += $product->stocks_s + $product->stocks_m + $product->stocks_l + $product->stocks_xl;
                                    }
                                @endphp
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalstocks }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="ti ti-stack-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row box-wrapper">
                <div class="col-xl-4 col-md-4 mb-2">
                    <div class="card shadow">
                        <div class="card-body d-flex align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Order(s)</div>
                                @php
                                    use App\Models\Order;

                                    $orderCount = Order::where('status', 'pending')->count();
                                    $processingCount = Order::where('status', 'processing')->count();
                                    $completedOrdersCount = Order::where('status', 'completed')->count();
                                    $cancelledOrdersCount = Order::where('status', 'cancelled')->count();
                                @endphp
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $orderCount + $processingCount}}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="ti ti-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4 mb-2">
                    <div class="card shadow">
                        <div class="card-body d-flex align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Completed</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedOrdersCount }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="ti ti-shopping-cart-copy"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4 mb-2">
                    <div class="card shadow">
                        <div class="card-body d-flex align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Cancelled</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cancelledOrdersCount }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="ti ti-shopping-cart-x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        <h3>Inventory</h3>
    </div>
    <div class="container rounded-sm rounded-3 card text-bg-dark box-pannel d-flex justify-content-center">
        <div class="box-border">
            <div class="container d-flex cont-bttn">
                <div class="d-flex bttn-wrapper">
                    <a class="btn-labeled" data-bs-toggle="modal" data-bs-target="#pop-modal">
                        <span class="new-label"><i class="ti ti-plus"></i></span>
                        <span style="margin:0px 15px 0px 15px">New</span>
                    </a>
                    <a href="{{ route('user.shop') }}" class="ms-auto btn-labeled">
                        <span style="margin:0px 15px 0px 15px">Preview</span>
                        <span class="preview-label"><i class="ti ti-eye"></i></span>
                    </a>
                </div>
            </div>
            <div class="cont-tble">
                <div class="table-reponsive-md">
                    <table class="table table-hover table-dark table-bordered table-striped">
                        <tr>
                            <th>ID</th>
                            <th>Item name</th>
                            <th>Size = Stocks</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Image 1</th>
                            <th>Image 2</th>
                            <th>Stock status</th>
                            <th class="edit-th">Actions</th>
                        </tr>
                        @foreach ($products as $product)
                                                <tr data-product-id="{{ $product->id }}">
                                                    <td>{{ $product->id }}</td>
                                                    <td class="product-item_name">{{ $product->item_name }}</td>
                                                    <td>
                                                        S = <span class="product-stocks_s">{{ $product->stocks_s }}</span><br>
                                                        M = <span class="product-stocks_m">{{ $product->stocks_m }}</span><br>
                                                        L = <span class="product-stocks_l">{{ $product->stocks_l }}</span><br>
                                                        XL = <span class="product-stocks_xl">{{ $product->stocks_xl }}</span>
                                                    </td>
                                                    <td class="product-price">${{ $product->price }}</td>
                                                    <td>{{ $product->category }}</td>
                                                    <td><img src="{{ asset('storage/' . $product->image1) }}" style="width:70px;"
                                                            alt="{{ $product->item_name }} Image 1"></td>
                                                    <td><img src="{{ asset('storage/' . $product->image2) }}" style="width:70px;"
                                                            alt="{{ $product->item_name }} Image 2"></td>
                                                    <td>
                                                        @php
                                                            $totalstocks = 0;
                                                            $totalstocks += $product->stocks_s + $product->stocks_m + $product->stocks_l + $product->stocks_xl + $product->stocks_2xl + $product->stocks_3xl;
                                                        @endphp
                                                        @if($totalstocks <= 9)
                                                            low on stocks
                                                        @else
                                                            High on stocks
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-around align-items-center mt-3">
                                                            <a href="{{route('Admin.edit', ['product' => $product])}}">
                                                                <button class="btn btn-primary rounded-0 edit-btn" data-bs-toggle="modal"
                                                                    data-bs-target="#pop-modal-2">
                                                                    <i class="ti ti-edit"></i>
                                                                </button></a>
                                                            <form method="post" action="{{ route('Admin.delete', ['product' => $product]) }}">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-danger del-btn rounded-0" type="submit">
                                                                    <i class="ti ti-trash"></i>
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('Admin.toggleAvailability', ['product' => $product->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('patch')
                                                                <button class="btn btn-secondary toggle-btn rounded-0" type="submit">
                                                                    @if($product->unavailable)
                                                                        Unavailable
                                                                    @else
                                                                        Available
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>

                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="pop-modal" style="z-index:999999;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Place a new product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        @if($errors->any())
                            <ul class="bullet" type="square">
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    @if(session()->has('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form id="product-form" method="post" action="{{ route('Admin.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="item-list">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="item_name">Item Name</label>
                                <input class="form-control" type="text" id="item_name" name="item_name">
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="description">Description</label>
                                <input class="form-control" type="text" id="description" name="description">
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="price">Price</label>
                                <input class="form-control" type="text" id="price" name="price">
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="size_s" name="size[]" value="S"
                                    onclick="dynInput(this);">
                                <label class="form-check-label" for="size_s">S</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="size_m" name="size[]" value="M"
                                    onclick="dynInput(this);">
                                <label class="form-check-label" for="size_m">M</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="size_l" name="size[]" value="L"
                                    onclick="dynInput(this);">
                                <label class="form-check-label" for="size_l">L</label>
                            </div>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="checkbox" id="size_xl" name="size[]" value="XL"
                                    onclick="dynInput(this);">
                                <label class="form-check-label" for="size_xl">XL</label>
                            </div>
                            <label class="vr" for="size">&nbsp;Size</label>
                            <div id="insertinputs"></div>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="radio" id="hoodie" name="category" value="Hoodie">
                                <label class="form-check-label" for="hoodie">Hoodie</label>
                            </div>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="radio" id="cap" name="category" value="Cap">
                                <label class="form-check-label" for="cap">Cap</label>
                            </div>
                            <div class="form-check form-check-inline mb-3">
                                <input class="form-check-input" type="radio" id="top" name="category" value="Top">
                                <label class="form-check-label" for="top">Top</label>
                            </div>
                            <label class="vr" for="category">&nbsp;Category</label>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="image1">Image 1</label>
                                <input type="file" class="form-control" id="image1" name="image1">
                            </div>
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="image2">Image 2</label>
                                <input type="file" class="form-control" id="image2" name="image2">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitForm()" id="liveToastBtn">Save</button>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editProductModal = document.getElementById('editProductModal');
        editProductModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var productId = button.getAttribute('data-bs-product-id');

            fetch(`/admin/products/${productId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_product_id').value = data.id;
                    document.getElementById('edit_item_name').value = data.item_name;
                    document.getElementById('edit_price').value = data.price;
                    document.getElementById('edit_stocks_s').value = data.stocks_s;
                    document.getElementById('edit_stocks_m').value = data.stocks_m;
                    document.getElementById('edit_stocks_l').value = data.stocks_l;
                    document.getElementById('edit_stocks_xl').value = data.stocks_xl;
                });
        });
    });
</script>

</html>