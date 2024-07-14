<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview &nbsp;&nbsp;| &nbsp;&nbsp;{{ $product->item_name }}</title>
    <link href="{{ asset('/css/preview.css') }}" type="text/css" rel="stylesheet">
    @include('user.header')
</head>

<body style="background-image: url('/images/paintbg.jpg');">
    <nav class="navbar navbar-dark">
        <a class="navbar-brand" href="user.home" style="visibility:hidden;">
            <img class="img_size" src="{{ asset('/logo/R_chrome.png') }}" alt="Rager">
        </a>
    </nav>
    <div class="parallax d-flex justify-content-center align-items-center">
        <h1>Preview / {{ $product->item_name }}</h1>
    </div>
    <div class="cont-container" style="background-image:url(/images/paintbg.png)">
        <div class="product-container">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 product-images d-flex justify-content-start" style="opacity:0.85">
                        <div class="img-container" id="imgContainer">
                            <img src="{{ asset('storage/' . $product->image1) }}" class="product-image"
                                id="productImage" alt="{{ $product->item_name }} Image 1">
                            <div class="zoom-container" id="zoomContainer"></div>
                        </div>
                    </div>
                    <div class="col-lg-5 product-details">
                        <div class="message-container">
                            @if(session('success'))
                                <div class="alert alert-success" id="successMessage">
                                    {{ session('success') }}
                                    <span class="close-btn" onclick="closeMessage('successMessage')"><i
                                            class="fa-solid fa-xmark"></i></span>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger" id="errorMessage">
                                    {{ session('error') }}
                                    <span class="close-btn ms-auto" onclick="closeMessage('errorMessage')"><i
                                            class="fa-solid fa-xmark"></i></span>
                                </div>
                            @endif
                        </div>
                        <div class="product-cont">
                            <h1>{{ $product->item_name }}</h1>
                            <div class="product-price">₱ {{ $product->price }}</div>
                            <div class="product-description">{{ $product->description }}</div>
                            <form id="addToCartForm" action="{{ route('add_to_cart', $product->id) }}" method="POST">
                                @csrf
                                @php
                                    $totalStock = 0;
                                    if ($product->stocks_s > 0)
                                        $totalStock += $product->stocks_s;
                                    if ($product->stocks_m > 0)
                                        $totalStock += $product->stocks_m;
                                    if ($product->stocks_l > 0)
                                        $totalStock += $product->stocks_l;
                                    if ($product->stocks_xl > 0)
                                        $totalStock += $product->stocks_xl;
                                @endphp
                                <div class="d-flex justify-content-start align-items-center cont-size">
                                    <div class="d-flex justify-content-start align-items-center sizes"
                                        style="width:100%;">
                                        <label class="label-size col-lg-3 col-md-2 col-sm-3" for="size"
                                            style="color: white;">Size</label>
                                        <div class="size-options col-lg-9 col-md-10 col-sm-9">
                                            @if($product->stocks_s > 0)
                                                <input type="radio" class="btn-check" id="size_s" name="size" value="S"
                                                    onclick="updateStock('S')">
                                                <label class="btn-size" for="size_s">S</label>
                                            @else
                                                <input type="radio" class="btn-check" id="size_s" name="size" value="S"
                                                disabled>
                                                <label class="btn-size disabled" for="size_s">S</label>
                                            @endif

                                            @if($product->stocks_m > 0)
                                                <input type="radio" class="btn-check" id="size_m" name="size" value="M"
                                                    onclick="updateStock('M')">
                                                <label class="btn-size" for="size_m">M</label>
                                            @else
                                                <input type="radio" class="btn-check" id="size_m" name="size" value="M"
                                                    disabled>
                                                <label class="btn-size disabled" for="size_m">M</label>
                                            @endif

                                            @if($product->stocks_l > 0)
                                                <input type="radio" class="btn-check" id="size_l" name="size" value="L"
                                                    onclick="updateStock('L')">
                                                <label class="btn-size" for="size_l">L</label>
                                            @else
                                                <input type="radio" class="btn-check" id="size_l" name="size" value="L"
                                                    disabled>
                                                <label class="btn-size disabled" for="size_l">L</label>
                                            @endif

                                            @if($product->stocks_xl > 0)
                                                <input type="radio" class="btn-check" id="size_xl" name="size" value="XL"
                                                    onclick="updateStock('XL')">
                                                <label class="btn-size" for="size_xl">XL</label>
                                            @else
                                                <input type="radio" class="btn-check" id="size_xl" name="size" value="XL"
                                                    disabled>
                                                <label class="btn-size disabled" for="size_xl">XL</label>
                                            @endif

                                            @if($product->stocks_2xl > 0)
                                                <input type="radio" class="btn-check" id="size_2xl" name="size" value="2XL"
                                                    onclick="updateStock('2XL')">
                                                <label class="btn-size" for="size_2xl">2XL</label>
                                            @else
                                                <input type="radio" class="btn-check" id="size_2xl" name="size" value="2XL"
                                                    disabled>
                                                <label class="btn-size disabled" for="size_2xl">2XL</label>
                                            @endif

                                            @if($product->stocks_3xl > 0)
                                                <input type="radio" class="btn-check" id="size_3xl" name="size" value="3XL"
                                                    onclick="updateStock('3XL')">
                                                <label class="btn-size" for="size_3xl">3XL</label>
                                            @else
                                                <input type="radio" class="btn-check" id="size_3xl" name="size" value="3XL"
                                                    disabled>
                                                <label class="btn-size disabled" for="size_3xl">3XL</label>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="d-flex justify-content-start align-items-center cont-quant">
                                    <label class="label-size col-lg-3 col-md-2 col-sm-3" for="quantity"
                                        style="color: white;">Quantity</label>
                                    <div class="text-quan col-lg-9 col-md-10 col-sm-9">
                                        <input type="number" id="quantity" value="1" min="1" name="quantity"
                                            oninput="validateQuantity()" style="border: 1px solid #3d3d3dad;">
                                        <span id="stock-info" style="opacity:0.6; font-size:13px;">{{$totalStock}}
                                            item/s of
                                            all sizes available</span>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" id="addToCartButton" class="btn btn-cout"
                                        style="background-color: black; border: none; border-radius: 0; color:white; padding: 10px 15px; margin-top: 10px;"
                                        disabled>
                                        add to cart
                                    </button>
                                </div>
                            </form>
                            <div id="quantityError" style="color: red; display: none;">Quantity exceeds available stock
                            </div>
                            &nbsp;
                            <div class="sku-cat" style="color: white;">
                                <div>
                                    <label for="sku">Category: </label><span>&emsp;&emsp;{{ $product->category }}</span>
                                </div>
                                <button type="button" class="btn btn-chart btn-primary pt-3" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    size chart
                                </button>

                                <div class="modal fade" id="exampleModal" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered round-0">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Rage in size</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="{{ asset('storage/' . $product->image2) }}" class="img-fluid"
                                                    id="sizeChartImg" alt="{{ $product->item_name }} Image 1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container" style="padding:10vh 0vh; opacity:0.85">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <h2 style="color:white">Related Products</h2>
                        <div class="related-prdcts d-flex flex-wrap" style="width:100%;">
                            @if ($relatedProducts->count() >= 3)
                                @foreach ($relatedProducts->take(3) as $relatedProduct)
                                    <div class="prdct-wrap col-lg-4 col-md-6 col-sm-12"
                                        data-category="{{ $relatedProduct->category }}">
                                        <div class="card" style="border:0; border-radius:20px;">
                                            <div class="product">
                                                <div class="img-size d-flex justify-content-center">
                                                    <a href="{{ route('user.preview', ['product' => $relatedProduct->id]) }}">
                                                        <img src="{{ asset('storage/' . $relatedProduct->image1) }}"
                                                            class="img-fluid" alt="{{ $relatedProduct->item_name }} Image 1">
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mb-3">
                                            <div>
                                                <div class="d-flex justify-content-center name">
                                                    <a
                                                        href="{{ route('user.preview', ['product' => $relatedProduct->id]) }}">{{ $relatedProduct->item_name }}</a>
                                                </div>

                                                <div class="d-flex justify-content-center price">
                                                    ₱{{ number_format($relatedProduct->price, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($relatedProducts as $relatedProduct)
                                    <div class="prdct-wrap col-lg-4 col-md-6 col-sm-12"
                                        data-category="{{ $relatedProduct->category }}">
                                        <div class="card" style="border:0; border-radius:0;">
                                            <div class="product">
                                                <div class="img-size d-flex justify-content-center">
                                                    <a href="{{ route('user.preview', ['product' => $relatedProduct->id]) }}">
                                                        <img src="{{ asset('storage/' . $relatedProduct->image1) }}"
                                                            class="img-fluid" alt="{{ $relatedProduct->item_name }} Image 1">
                                                    </a>
                                                </div>
                                                <div class="product-info d-flex justify-content-center align-items-center">
                                                    <div class="product-icons">
                                                        <a
                                                            href="{{ route('user.preview', ['product' => $relatedProduct->id]) }}"><i
                                                                class="fa fa-eye"></i></a>
                                                        <a href="#"><i class="fa fa-shopping-cart"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mb-2" style="width:100%">
                                            <div>
                                                <div class="class=" d-flex justify-content-center name">
                                                    <a href="{{ route('user.preview', ['product' => $relatedProduct->id]) }}">{{ $relatedProduct->item_name }}
                                                    </a>
                                                </div>
                                                <div class="d-flex justify-content-center price">
                                                    <span>₱{{ number_format($relatedProduct->price, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user.footerbtm')
    <script>
        const button = document.getElementById('addToCartButton');

        function toggleButton(isEnabled) {
            if (isEnabled) {
                button.disabled = false;
                button.style.opacity = '1';
            } else {
                button.disabled = true;
                button.style.opacity = '0.5';
            }
        }
        function resetQuantity() {
            document.getElementById('quantity').value = 1;
            validateQuantity();
        }

        function toggleAddToCartButton() {
            var addToCartButton = document.getElementById('addToCartButton');
            var radios = document.getElementsByName('size');
            var isChecked = false;

            for (var i = 0; i < radios.length; i++) {
                if (radios[i].checked) {
                    isChecked = true;
                    break;
                }
            }

            addToCartButton.disabled = !isChecked;
        }

        function validateQuantity() {
            var quantityInput = document.getElementById('quantity');
            var selectedSize = document.querySelector('input[name="size"]:checked');
            var addToCartButton = document.getElementById('addToCartButton');
            var quantityError = document.getElementById('quantityError');
            var maxStocks = 0;

            if (selectedSize) {
                switch (selectedSize.value) {
                    case 'S':
                        maxStocks = {{ $product->stocks_s }};
                        break;
                    case 'M':
                        maxStocks = {{ $product->stocks_m }};
                        break;
                    case 'L':
                        maxStocks = {{ $product->stocks_l }};
                        break;
                    case 'XL':
                        maxStocks = {{ $product->stocks_xl }};
                        break;
                    default:
                        break;
                }
            }

            if (quantityInput.value > maxStocks) {
                addToCartButton.disabled = true;
                quantityError.style.display = 'block';
            } else {
                addToCartButton.disabled = false;
                quantityError.style.display = 'none';
            }
        }

        window.onload = function () {
            var imgContainer = document.getElementById('imgContainer');
            var productImage = document.getElementById('productImage');
            var zoomContainer = document.getElementById('zoomContainer');

            imgContainer.addEventListener('mousemove', function (e) {
                var posX = e.offsetX;
                var posY = e.offsetY;
                var width = imgContainer.offsetWidth;
                var height = imgContainer.offsetHeight;
                var zoomFactor = window.innerWidth > 768 ? 2.8 : 2;
                var zoomedImageWidth = productImage.offsetWidth * zoomFactor;
                var zoomedImageHeight = productImage.offsetHeight * zoomFactor;
                var zoomContainerWidth = zoomContainer.offsetWidth;
                var zoomContainerHeight = zoomContainer.offsetHeight;

                var bgPosX = (posX / width) * (zoomedImageWidth - width);
                var bgPosY = (posY / height) * (zoomedImageHeight - height);

                zoomContainer.style.backgroundImage = 'url("' + productImage.src + '")';
                zoomContainer.style.backgroundSize = zoomedImageWidth + 'px ' + zoomedImageHeight + 'px';
                zoomContainer.style.backgroundPosition = '-' + bgPosX + 'px -' + bgPosY + 'px';
            });

            // Add event listeners to size options
            var sizeOptions = document.getElementsByName('size');
            sizeOptions.forEach(function (option) {
                option.addEventListener('change', toggleAddToCartButton);
            });

            // Initial check on page load
            toggleAddToCartButton();
        };
        const stocks = {
            S: @json($product->stocks_s),
            M: @json($product->stocks_m),
            L: @json($product->stocks_l),
            XL: @json($product->stocks_xl)
        };

        function updateStock(size) {
            const stockInfo = document.getElementById('stock-info');
            const availableStock = stocks[size] || 0;
            stockInfo.textContent = `${availableStock} pieces available`;
            document.getElementById('quantity').max = availableStock;
        }
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
                }, 5000); // 5 seconds
            }

            if (errorMessage) {
                setTimeout(function () {
                    errorMessage.style.display = 'none';
                }, 5000); // 5 seconds
            }
        }

        // Call hideMessages on page load
        document.addEventListener('DOMContentLoaded', function () {
            hideMessages();
        });
    </script>
</body>

</html>