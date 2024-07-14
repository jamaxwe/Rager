<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link href="{{ asset('/css/trackadmin.css') }}" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('/logo/R_logo_2.jpg') }}">
    @extends('Admin.layout')
</head>

<body>

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
                    style="white-space:nowrap; padding: 1vh 6vh;"><i class="ti ti-user-circle icon"> </i>Admin ID:
                    {{ auth()->user()->id }}</li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item d-flex justify-content-center align-items-center"
                       style="white-space:nowrap; padding: 1vh 6vh;" href="{{ route('logout') }}"><i
                            class="ti ti-logout-2 icon"> </i>
                    Logout</a></li>
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
<div class="container">
    <h1>Track Orders</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="GET" action="{{ route('Admin.trackorder') }}" id="filterForm">
        <div class="form-group">
            <select name="status" id="status" class="form-control" onchange="updateFilter(this.value)">
                <option value="">All</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
    </form>

    @if ($orders->isEmpty())
        <p>No orders found for selected status.</p>
    @else
    <div class="mt-4">
                @php
                    $groupedOrders = $orders->groupBy('status');
                @endphp
                @foreach (['pending', 'processing', 'completed', 'cancelled'] as $status)
                    @if ($groupedOrders->has($status))
                        <h6>{{ ucfirst($status) }}</h6>
                        @foreach ($groupedOrders[$status]->reverse() as $order)
                            <div class="btn-drop col-lg-12 mb-3">
                                <button style="width:100%;" class="btn-btn d-flex justify-content-start align-items-center"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrder{{ $order->id }}"
                                        aria-expanded="false" aria-controls="collapseOrder{{ $order->id }}">
                                    <div>
                                        <i style="color: 
                                                                                                                                                                                @if($order->status == 'pending') #e6b400 
                                                                                                                                                                                @elseif($order->status == 'processing') aqua 
                                                                                                                                                                                @elseif($order->status == 'completed') green
                                                                                                                                                                                @elseif($order->status == 'cancelled') red
                                                                                                                                                                                @endif;"
                                            class="fa-solid fa-circle"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ $order->tracking_no }}:
                                        {{ $order->fname }} {{ $order->lname }}
                                    </div>
                                    <div class="dropdown-toggle ms-auto">

                                    </div>
                                </button>
                                <div class="collapse" id="collapseOrder{{ $order->id }}" style="transition: all 0.3s;">
                                    <div class="card card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Order ID:</strong> {{ $order->id }}</p>
                                                <p><strong>Tracking Number:</strong> {{ $order->tracking_no }}</p>
                                                <p><strong>Status:</strong> {{ $order->status }}</p>
                                                <p><strong>Payment Method:</strong> {{ $order->paymentmethod }}
                                                    @if ($order->paymentmethod === 'Gcash' && $order->image)
                                                        <br>
                                                        <button type="button" class="btn btn-primary" id="gcash-image-btn"
                                                                style="height:200px; width:200px;">
                                                            <img src="{{ asset('storage/' . $order->image) }}" alt="Gcash Image"
                                                                 class="img-fluid" id="gcash-image">
                                                        </button>
                                                    @endif
                                                </p>
                                                @php             
                                                    $totalAmount = 0; 
                                                @endphp

                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Name:</strong> {{ $order->fname }} {{ $order->lname }}</p>
                                                <p><strong>Email:</strong> {{ $order->email }}</p>
                                                <p><strong>Mobile Number:</strong> {{ $order->mobilenumber }}</p>
                                                <p><strong>Address:</strong> {{ $order->address }}, {{ $order->barangay }},
                                                    {{ $order->city }}, {{ $order->zipcode }}
                                                </p>
                                                <p><strong>Message:</strong> {{ $order->message }}</p>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Item Name</th>
                                                        <th>Size</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($order->orderItems as $item)
                                                                        @php
                                                                            $totalAmount += $item->price * $item->quantity;
                                                                        @endphp
                                                                        <tr>
                                                                            <td>{{ $item->item }}</td>
                                                                            <td>{{ $item->size }}</td>
                                                                            <td>{{ $item->quantity }}</td>
                                                                            <td>${{ number_format($item->price, 2) }}</td>
                                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="d-flex">
                                                <div class="row no-gutters" style="width:100%;">
                                                    <div class="col-lg-9 col-md-9">
                                                        <p><strong>Total Amount:</strong> ${{ number_format($totalAmount, 2) }}</p>
                                                    </div>
                                                    <form action="{{ route('Admin.updatestatus', $order->id) }}" method="POST"
                                                          class="update-form col-lg-3 col-md-3">
                                                        @csrf
                                                        @method('POST')
                                                        <div class="form-group" style="width:100%">
                                                            <label for="status">Update Status:</label>
                                                            <select name="status" id="status-{{ $order->id }}" class="form-control" onchange="checkStatus({{ $order->id }}, '{{ $order->status }}')">
                                                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                            </select>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary update-btn" id="update-btn-{{ $order->id }}" onclick="return confirmUpdate()" disabled>Update Status</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function updateFilter(status) {
        document.getElementById('status').value = status;
        document.getElementById('filterForm').submit();
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageButton = document.getElementById('gcash-image-btn');
        const enlargeImage = document.getElementById('gcash-image');
        const enlargeImageOverlay = document.getElementById('enlargeImageOverlay');

        imageButton.addEventListener('click', function () {
            enlargeImage.classList.toggle('show');
            enlargeImageOverlay.classList.toggle('show');
        });

        enlargeImageOverlay.addEventListener('click', function () {
            enlargeImage.classList.remove('show');
            enlargeImageOverlay.classList.remove('show');
        });
    });
</script>
<script>
    // JavaScript function to update filter value and submit the form
    document.addEventListener('DOMContentLoaded', function () {
        var dropdownMenuButton = document.getElementById('statusDropdown');
        dropdownMenuButton.addEventListener('click', function () {
            var dropdownMenu = dropdownMenuButton.nextElementSibling;
            dropdownMenu.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', function (e) {
            if (!dropdownMenuButton.contains(e.target)) {
                var dropdownMenu = dropdownMenuButton.nextElementSibling;
                dropdownMenu.classList.remove('show');
            }
        });
    });

    const orderIds = @json($orders->pluck('id'));

    orderIds.forEach(function (orderId) {
        const selectElement = document.getElementById('status-' + orderId);
        const updateButton = document.getElementById('update-btn-' + orderId);
        const currentStatus = selectElement.value;

        selectElement.addEventListener('change', function () {
            if (selectElement.value !== currentStatus) {
                updateButton.disabled = false;
            } else {
                updateButton.disabled = true;
            }
        });

        const collapseButton = document.querySelector('[data-bs-target="#collapseOrder' + orderId + '"]');
        collapseButton.addEventListener('click', function () {
            const allCollapsibles = document.querySelectorAll('.collapse');
            allCollapsibles.forEach(function (collapsible) {
                if (collapsible.id !== 'collapseOrder' + orderId) {
                    const collapseInstance = new bootstrap.Collapse(collapsible, {
                        toggle: false
                    });
                    collapseInstance.hide();
                }
            });
        });
    });
</script>
<script>
    function confirmUpdate() {
        return confirm('Are you sure you want to update the status?');
    }
</script>

</body>
</html>
