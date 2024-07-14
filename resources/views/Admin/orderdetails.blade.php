<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<div class="container">
    <h1>Order Details</h1>

    <div class="card mb-4">
        <div class="card-header">
            <h4>Order Information</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Order ID:</strong> {{ $order->id }}</p>
                    <p><strong>Tracking Number:</strong> {{ $order->tracking_no }}</p>
                    <p><strong>Status:</strong> {{ $order->status }}</p>
                    <p><strong>Payment Method:</strong> {{ $order->paymentmethod }}</p>
                    <p><strong>Total:</strong> $<span id="totalAmount">{{ number_format($order->total, 2) }}</span></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $order->fname }} {{ $order->lname }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>Mobile Number:</strong> {{ $order->mobilenumber }}</p>
                    <p><strong>Address:</strong> {{ $order->address }}, {{ $order->barangay }}, {{ $order->city }}, {{ $order->zipcode }}</p>
                    <p><strong>Message:</strong> {{ $order->message }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Ordered Items</h4>
        </div>
        <div class="card-body">
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
                        @php
                            $totalAmount = 0;
                        @endphp
                        @foreach ($orderItems as $item)
                            <tr>
                                
                                <td>{{ $item->item }}</td>
                                <td>{{ $item->size }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                @php
                                    $totalAmount += $item->price * $item->quantity;
                                @endphp
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<a href="{{route('Admin.trackorder')}}">back</a>
    
</div>

<script>
    // Optional: Calculate total dynamically using JavaScript
    // This is to update the total if needed without reloading the page
    document.addEventListener('DOMContentLoaded', function() {
        var totalAmount = {{ $totalAmount }};
        document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);
        document.getElementById('totalAmountDisplay').textContent = totalAmount.toFixed(2);
    });
</script>

