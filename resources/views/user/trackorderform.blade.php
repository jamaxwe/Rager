<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rager - Track Your Order</title>
    <link href="{{ asset('/css/trackorder.css') }}" type="text/css" rel="stylesheet">
    @include('user.header')
</head>

<body style="background-image: url('/images/RAGE.png');">
    <nav class="navbar navbar-dark">
        <a class="navbar-brand" href="user.home" style="visibility:hidden;">
            <img class="img_size" src="{{ asset('/logo/R_chrome.png') }}" alt="Rager">
        </a>
    </nav>
    <div class="parallax d-flex justify-content-center align-items-center">
        <h1>Track Your Order</h1>
    </div>
    <div style="background-color: white; min-height:100vh; padding-bottom: 5vh">
        <div class="container tnum">
            <h2>Tracking Number</h2>
        </div>
        <div class="container" style="min-height:80vh; background-color: #eee; border-radius:10px">
            <div style="background-color: #eee; margin-bottom:40px;">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div style="padding:3vh 2vh">
                    <form action="{{ route('user.trackordersearch') }}" method="GET" class="d-flex" style="height:6vh">
                        <div class="form-group" style="width:100%;">
                            <input style="border-radius: 0px; height:6vh" type="text" id="tracking_number"
                                name="tracking_number" class="form-control form-cnt" required>
                        </div>
                        <button style="border-radius: 0px; background-color:black; border:none" type="submit"
                            class="btn btn-primary">
                            <i class="srch-btn fa-solid fa-magnifying-glass-arrow-right"></i>
                        </button>
                    </form>

                    @if (isset($order))
                                        <div class="container">
                                            <h1 style="padding:2vh 0vh;">Order Details</h1>

                                            <div class="card mb-4">
                                                <div class="card-header d-flex align-items-center"
                                                    style="background-color:#8b6c5c; color: white">
                                                    <h4>Order Information</h4>
                                                    <p style="padding-top:15px;" class="ms-auto"><strong>Status:</strong>
                                                        <span style="color: 
                                                                                                        @if($order->status == 'pending') yellow 
                                                                                                        @elseif($order->status == 'processing') aqua 
                                                                                                        @elseif($order->status == 'completed') lightgreen
                                                                                                        @elseif($order->status == 'cancelled') #F88379
                                                                                                        @endif; text-transform:uppercase;">
                                                            {{ $order->status }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-6 ">
                                                            <p><strong>Order ID:</strong> {{ $order->id }}</p>
                                                            <p><strong>Tracking Number:</strong> {{ $order->tracking_no }}</p>
                                                            <p><strong>Payment Method:</strong> {{ $order->paymentmethod }}</p>
                                                            <p><strong>Total:</strong> $<span
                                                                    id="totalAmount">{{ number_format($order->total, 2) }}</span></p>
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
                                                </div>
                                            </div>

                                            <div class="card">
                                                <div class="card-header" style="background-color:#8b6c5c; color: white">
                                                    <h4>Ordered Items</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table">
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
                                        </div>
                                        @if($order->status === 'completed')
                                            <div id="rating-popup" class="rating-popup hidden">
                                                <div class="button-container">
                                                    <button id="close-popup" class="btn-close">&times;</button>
                                                </div>
                                                <div class="popup-content">
                                                    <h5>PLEASE RATE US!</h5>
                                                    <form id="rating-form" action="{{ route('rate.product', ['product' => $order->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <div class="form-group mb-3">
                                                            <div class="star-rating">
                                                                <input type="radio" id="5-stars" name="rating" value="5" />
                                                                <label for="5-stars" class="star">&#9733;</label>
                                                                <input type="radio" id="4-stars" name="rating" value="4" />
                                                                <label for="4-stars" class="star">&#9733;</label>
                                                                <input type="radio" id="3-stars" name="rating" value="3" />
                                                                <label for="3-stars" class="star">&#9733;</label>
                                                                <input type="radio" id="2-stars" name="rating" value="2" />
                                                                <label for="2-stars" class="star">&#9733;</label>
                                                                <input type="radio" id="1-star" name="rating" value="1" />
                                                                <label for="1-star" class="star">&#9733;</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Rate Order</button>
                                                    </form>
                                                </div>
                                            </div>

                                        @endif
                    @else
                        <div class="container emt-search d-flex justify-content-center align-items-center"
                            style="min-height:80vh;">
                            <h2>No search yet or no items found.</h2>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <footer>
        @include('user.footerbtm')
    </footer>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var totalAmount = {{ $totalAmount }};
            document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);

            // Check if the order is completed and if the user hasn't rated this order yet
            const orderStatus = '{{ $order->status }}';
            const orderId = '{{ $order->id }}';
            const ratedOrders = JSON.parse(localStorage.getItem('ratedOrders')) || [];

            if (orderStatus === 'completed' && !ratedOrders.includes(orderId)) {
                showRatingPopup();
            }

            // Function to show the rating popup
            function showRatingPopup() {
                const popup = document.getElementById('rating-popup');
                popup.classList.remove('hidden');
                setTimeout(() => {
                    popup.classList.add('show');
                }, 5000);
            }

            // Handle form submission and store the rating state
            const ratingForm = document.getElementById('rating-form');
            ratingForm.addEventListener('submit', function (e) {
                e.preventDefault();
                // Store the rated order ID
                ratedOrders.push(orderId);
                localStorage.setItem('ratedOrders', JSON.stringify(ratedOrders));
                closePopup();
                ratingForm.submit(); // Proceed with form submission
            });

            // Handle close button
            const closePopupButton = document.getElementById('close-popup');
            closePopupButton.addEventListener('click', function () {
                closePopup();
            });

            function closePopup() {
                const popup = document.getElementById('rating-popup');
                popup.classList.remove('show');
                setTimeout(() => {
                    popup.classList.add('hidden');
                }, 3000);
            }
        });
    </script>
</body>

</html>