<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <link href="{{ asset('/css/cart.css') }}" type="text/css" rel="stylesheet">
    @include('user.header')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body style="background-image: url('/images/bgrage.jpg');">
    <nav class="navbar navbar-dark">
        <a class="navbar-brand" href="user.home" style="visibility:hidden;">
            <img class="img_size" src="{{ asset('/logo/R_chrome.png') }}" alt="Rager">
        </a>
    </nav>
    <div class="parallax">
        <h1 class="d-flex justify-content-center align-items-center">Cart</h1>
    </div>
    <div class="message-container">
                            @if(session('success'))
                                <div class="alert alert-success" id="successMessage">
                                    {{ session('success') }}
                                    <span class="close-notif" onclick="closeMessage('successMessage')"><i
                                            class="fa-solid fa-xmark"></i></span>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger" id="errorMessage">
                                    {{ session('error') }}
                                    <span class="close-notif" onclick="closeMessage('errorMessage')"><i
                                            class="fa-solid fa-xmark"></i></span>
                                </div>
                            @endif
                        </div>
    <div class="Cont-cart"
        style="background-image:url(/images/chainbg.png); min-height:70vh; overflow-y: auto; scrollbar-width: none;">
        <div class="bgcolor" style="padding:5vh 0vh">
            <div class="container">
                <div class="row stlbg no-gutters" style="height:auto;">
                    @if(session('cart') && count(session('cart')) > 0)
                                    <div class="col-lg-12">
                                        <div class="table-cont table-responsive">
                                            <table class="tble">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php    $total = 0 @endphp
                                                    @foreach(session('cart', []) as $id => $details)
                                                                                    @php
                                                                                        $subtotal = $details['price'] * $details['quantity'];
                                                                                        $total += $subtotal;
                                                                                    @endphp
                                                                                    <tr data-id="{{ $id }}">
                                                                                        <td data-th="Remove">
                                                                                            <form method="POST" action="{{ route('cart.delete', $id) }}">
                                                                                                @csrf
                                                                                                @method('DELETE')
                                                                                                <button type="submit" class="close-btn"><i
                                                                                                        class="fa-solid fa-xmark"></i></button>
                                                                                            </form>
                                                                                        </td>
                                                                                        <td data-th="Thumbnail" style="width:80px; height:50px;">
                                                                                            <img src="{{ asset('storage/' . $details['image1']) }}"
                                                                                                alt="{{ $details['item_name'] }}" class="img-fluid" />
                                                                                        </td>
                                                                                        <td data-th="Product">
                                                                                            <span
                                                                                                style="font-weight:650; text-transform:lowercase; width:50px; font-size:19px; margin-left:10px;">
                                                                                                {{ $details['item_name'] }}
                                                                                                <span style="text-transform: uppercase;">({{ $details['size'] }})</span>
                                                                                            </span>
                                                                                        </td>
                                                                                        <td data-th="Price" class="price" data-price="{{ $details['price'] }}">
                                                                                            ₱{{ $details['price'] }}
                                                                                        </td>
                                                                                        <td data-th="Quantity">
                                                                                            <input type="number" id="quantity" class="quantity"
                                                                                                value="{{ $details['quantity'] }}" min="1" name="quantity" readonly>
                                                                                        </td>
                                                                                        <td class="subtotal" data-th="Subtotal">
                                                                                            ₱{{ $subtotal }}.00
                                                                                        </td>
                                                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="background-color:#eff5f1; border-radius:20px">
                                        <div class="check-sec">
                                            <h2 style="font-weight:700;">cart totals</h2>
                                            <div class="cart-ttl">
                                                <table style="width:100%;">
                                                    <tbody>
                                                        <tr>
                                                            <th style="width:50%">
                                                                Subtotal
                                                            </th>
                                                            <td class="subtotal2" data-th="Subtotal" style="padding: 20px 0px;">
                                                                ₱{{ $subtotal }}.00
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th style="width:50%">
                                                                Shipping
                                                            </th>
                                                            <td style="padding: 20px 0px;">
                                                                <a class="btn btn-edt btn-primary btn-no-bg" data-bs-toggle="collapse"
                                                                    href="#collapseExample" role="button" aria-expanded="false"
                                                                    aria-controls="collapseExample">
                                                                    <span>Enter your address</span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr
                                                            style="border-top: 2px solid; border-color: rgba(0, 0, 0, 0.3); border-width: ;">
                                                            <th style="width:50%">
                                                                Total
                                                            </th>
                                                            <td style="padding: 40px 0px;">

                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div>
                                                </div>

                                            </div>
                                            <div class="collapse" id="collapseExample">
                                                <h5>Checkout</h5>
                                                <form id="checkoutForm" method="POST" action="{{ route('user.placeorder') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="surname">Surname<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="lname" name="lname" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="firstname">Firstname<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="fname" name="fname" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address">Address<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="address" name="address" required>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="city">City<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="city" name="city" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="barangay">Barangay<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="barangay" name="barangay"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="zip">ZIP Code<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="zipcode" name="zipcode"
                                                                required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="mobilenumber">Mobile Number<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="mobilenumber"
                                                                name="mobilenumber" maxlength="11" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="email">Email<span class="text-danger">*</span></label>
                                                            <input type="email" class="form-control" id="email" name="email" required>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="payment_method">Payment Method</label>
                                                            <br>
                                                            <input type="radio" name="paymentmethod" value="COD" required> COD <span>&nbsp;&nbsp;</span>
                                                            <input type="radio" name="paymentmethod" value="Gcash" required> Gcash
                                                        </div>

                                                    </div>
                                                    <div class="form-group" id="gcash-image-input" style="display: none;">
                                                        <label for="image">Upload Gcash Receipt<span class="text-danger">*</span></label>
                                                        <input type="file" class="form-control" id="image" name="image">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="surname">Message</label>
                                                        <textarea type="textaria" class="form-control" id="message"
                                                            name="message"></textarea>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" id="confirmCheckoutBtn" class="btn btn-cout"
                                                    style="background-color: black; border: none; border-radius: 0; color:white; padding: 10px 20px;"
                                                    disabled>
                                                    Confirm Checkout
                                                </button>
                                            </div>
                                            </form>
                                        </div>
                    @else
                        <div class="return-shop">
                            <a href="/shop">
                                <i class="fa-solid fa-arrow-left"></i><span>&nbsp; return to shop</span>
                            </a>
                            <a href="{{route('user.trackorderform')}}">
                                <span>Track Order &nbsp;</span><i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="empty-icon-container">
                            <div><i class="fa-solid fa-box-open"></i></div>
                            <div class="container" style="text-align: center;">
                                <h2>Your cart is currently empty.</h2>
                            </div>

                        </div>

                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user.footerbtm')
    <script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                document.getElementById('checkoutForm').reset();
                document.getElementById('collapseExample').classList.remove('show');
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            toggleGcashImageInput();

            // Add event listeners to form fields for validation
            var formFields = document.querySelectorAll('#checkoutForm input, #checkoutForm select');
            formFields.forEach(function (field) {
                field.addEventListener('change', validateForm);
            });

            // Check initial form validity
            validateForm();
        });


        // Function to handle cart update on quantity change
        $('.cart_update').change(function () {
            var id = $(this).data('id');
            var quantity = $(this).val();

            $.ajax({
                type: 'PATCH',
                url: '{{ route('cart.update') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    quantity: quantity
                },
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Failed to update cart. Please try again.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert('An error occurred while updating the cart.');
                }
            });
        });

        $(document).ready(function () {
            // Function to handle visibility of image upload based on payment method selection
            $('input[name="paymentmethod"]').change(function () {
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

                formFields.each(function () {
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
            $('input[name="paymentmethod"]').change(function () {
                validateForm();
            });

            // Event listener for form field changes
            $('#checkoutForm input, #checkoutForm select').change(function () {
                validateForm();
            });

            // Initial call to set initial state
            validateForm();
        });

        $('.quantity').on('input', function () {
            var row = $(this).closest('tr');
            var price = parseFloat(row.find('.price').data('price'));
            var quantity = parseInt($(this).val());
            var subtotal = price * quantity;
            row.find('.subtotal').text('₱' + subtotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));;

            updateTotal();
        });

        function updateTotal() {
            var total = 0;
            $('.tble tbody tr').each(function () {
                var price = parseFloat($(this).find('.price').data('price'));
                var quantity = parseInt($(this).find('.quantity').val());
                var subtotal = price * quantity;
                total += subtotal;
            });

            // Update the displayed total
            $('.subtotal2').text('₱' + total.toFixed(2));
        }

        $(document).ready(function () {
            $('.quantity').on('input', function () {
                var row = $(this).closest('tr');
                var price = parseFloat(row.find('.price').data('price'));
                var quantity = parseInt($(this).val());
                var subtotal = price * quantity;
                row.find('.subtotal').text('₱' + subtotal.toFixed(2));
                updateTotal();
            });

            updateTotal();
        });
    </script>
    <script>
        // Function to close the message
        function closeMessage(messageId) {
            var message = document.getElementById(messageId);
            message.style.display = 'none';
        }

        // Function to automatically hide messages after a delay
        function hideMessages() {
            var successMessage = document.getElementById('successMessage');
            var errorMessage = document.getElementById('errorMessage');

            if (successMessage) {
                setTimeout(function () {
                    successMessage.style.display = 'none';
                }, 3000); // 3 seconds
            }

            if (errorMessage) {
                setTimeout(function () {
                    errorMessage.style.display = 'none';
                }, 3000); // 3 seconds
            }
        }

        // Call hideMessages on page load
        document.addEventListener('DOMContentLoaded', function () {
            hideMessages();
        });
    </script>
</body>

</html>