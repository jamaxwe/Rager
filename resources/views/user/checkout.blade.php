<!-- checkout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
</head>
<body>
    @php $total = 0 @endphp
    @forelse(session('cart', []) as $id => $details)
        @php 
            $subtotal = $details['price'] * $details['quantity'];
            $total += $subtotal;
        @endphp
    @empty
        <!-- Handle empty cart -->
    @endforelse

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="container">
        <form id="checkoutForm" method="POST" action="{{ route('user.placeorder') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Cart Items</h5>
                        <ul class="list-group">
                            @forelse(session('cart', []) as $id => $details)
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $details['image1']) }}" alt="{{ $details['item_name'] }}" style="width: 50px; height: 50px;">
                                        <div class="ml-3">
                                            <p>{{ $details['item_name'] }}</p>
                                            <p>Size: {{ $details['size'] }}</p>
                                            <p>Price: ${{ $details['price'] }}</p>
                                            <p>Quantity: {{ $details['quantity'] }}</p>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item">
                                    No items in cart
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" name="lname" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="firstname">Firstname</label>
                                <input type="text" class="form-control" name="fname" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="city">City</label>
                                <input type="text" class="form-control" name="city" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="barangay">Barangay</label>
                                <input type="text" class="form-control" name="barangay" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="zip">ZIP Code</label>
                                <input type="text" class="form-control" name="zipcode" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobilenumber">Mobile Number</label>
                                <input type="text" class="form-control" name="mobilenumber" maxlength="11" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="payment_method">Payment Method</label>
                                <input type="radio" name="paymentmethod" value="COD"> COD
    <input type="radio" name="paymentmethod" value="Gcash"> Gcash
                            </div>

                        </div>
                        <div class="form-group" id="gcash-image-input" style="display: none;">
    <label for="image">Upload Gcash Receipt</label>
    <input type="file" class="form-control" id="image" name="image">
</div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <input type="text" class="form-control" id="message" name="message">
                        </div>
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" class="form-control" id="total" name="total" value="{{ number_format($total, 2) }}" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" id="confirmCheckoutBtn" class="btn btn-primary" disabled>Confirm Checkout</button>
            </div>
        </form>
    </div>

    <a href="{{ route('user.shop') }}" class="btn btn-primary">Continue Shopping</a>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Function to handle visibility of image upload based on payment method selection
            $('input[name="paymentmethod"]').change(function() {
                var paymentMethod = $(this).val();
                var gcashImageInput = $('#gcash-image-input');

                if (paymentMethod === 'Gcash') {
                    gcashImageInput.show();
                } else {
                    gcashImageInput.hide();
                }

                // Validate form when payment method changes
                validateForm();
            });

            // Initial check on page load
            var initialPaymentMethod = $('input[name="paymentmethod"]:checked').val();
            if (initialPaymentMethod === 'Gcash') {
                $('#gcash-image-input').show();
            }

            
            

            // Validate form function
            function validateForm() {
                var isValid = true;
                var formFields = $('#checkoutForm input, #checkoutForm select');

                formFields.each(function() {
                    if (!this.checkValidity()) {
                        isValid = false;
                    }
                });

                // Additional validation logic for Gcash payment method
                if ($('input[name="paymentmethod"]:checked').val() === 'Gcash') {
                    if ($('#image').get(0).files.length === 0) {
                        isValid = false;
                    }
                }

                // Enable or disable submit button based on form validity
                $('#confirmCheckoutBtn').prop('disabled', !isValid);
            }

            // Event listener for payment method change
            $('input[name="paymentmethod"]').change(function() {
                validateForm();
            });

            // Event listener for form field changes
            $('#checkoutForm input, #checkoutForm select').change(function() {
                validateForm();
            });

            // Initial call to set initial state
            validateForm();
        });
    </script>
</body>
</html>
