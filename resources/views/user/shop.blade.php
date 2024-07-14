<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/css/shop.css') }}" type="text/css" rel="stylesheet">
    <title>Shop</title>
    @include('user.header')
</head>

<body style="background-image: url('images/peace.jpg');">
    <nav class="navbar navbar-dark">
        <a class="navbar-brand" href="user.home" style="visibility:hidden;">
            <img class="img_size" src="{{ asset('/logo/R_chrome.png') }}" alt="Rager">
        </a>
    </nav>
    <div class="parallax d-flex justify-content-center align-items-center">
        <h1>Products</h1>
    </div>
    <div class="cont-content" style=" min-height:80vh; background-image:url(/images/download.png)">
        <div class="opct" style="width:100%; height:100%;">
            <div class="container">
                <div class="row" style="padding-top:10vh; padding-bottom: 5vh;">
                    <div class="sidebar col-lg-2 order-lg-1">
                        <div class="line-wrp">
                            <div class="line">
                                <h3>Categories</h3>
                            </div>
                        </div>
                        <ul id="category">
                            <li><a href="#" data-value="all" class="{{ $category == 'all' ? 'active' : '' }}">All</a>
                            </li>
                            <li><a href="#" data-value="top" class="{{ $category == 'top' ? 'active' : '' }}">Top</a>
                            </li>
                            <li><a href="#" data-value="hoodie"
                                    class="{{ $category == 'hoodie' ? 'active' : '' }}">Hoodie</a></li>
                            <li><a href="#" data-value="cap" class="{{ $category == 'cap' ? 'active' : '' }}">Cap</a>
                            </li>
                        </ul>
                    </div>
                    <div class="main-content col-lg-10 order-lg-2">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="container prdct-cont" id="product-container">
                            <div class="row forow" style="width:100%; min-height:65vh;">
                                @if($products->isEmpty())
                                    <div class="col-12 d-flex align-items-center justify-content-center"
                                        style="width:100%; height:100%;">
                                        <div class="text-center"
                                            style="font-size:20px; font-weight:700; opacity:0.5; color:white">
                                            <i class="fa-solid fa-box-open" style="font-size:40px;"></i>
                                            <p>No products available in this category.</p>
                                        </div>
                                    </div>
                                @else
                                    @foreach($products as $product)
                                        <div class="prdct-wrap col-lg-4 col-md-6 col-sm-12"
                                            data-category="{{ $product->category }}">
                                            <div class="card @if(!$product->unavailable) available @endif"
                                                style="border:0; border-radius:20px; opacity:0.85;">
                                                <div class="product">
                                                    <div class="img-size d-flex justify-content-center">
                                                        <a href="{{ route('user.preview', ['product' => $product->id]) }}">
                                                            <img src="{{ asset('storage/' . $product->image1) }}"
                                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                                class="img-fluid" alt="{{ $product->item_name }} Image 1">
                                                        </a>
                                                    </div>
                                                    @if($product->unavailable)
                                                        <div class="product-info d-flex justify-content-center align-items-center">
                                                            <div class="unavailable-overlay product-icons">
                                                                <span class="unv">Unavailable</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center mb-4 mt-2">
                                                <div>
                                                    <div class="d-flex justify-content-center name">
                                                        <a
                                                            href="{{ route('user.preview', ['product' => $product->id]) }}">{{ $product->item_name }}</a>
                                                    </div>
                                                    <div class="d-flex justify-content-center price">
                                                        ₱{{ number_format($product->price, 2) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="page-cont d-flex justify-content-center align-items-end col-lg-12 pt-3">
                            <div class="page-wrap">
                                {{ $products->appends(['category' => $category])->links('vendor.pagination.bootstrap-4') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </div>

    @include('user.footerbtm')

    <script>
        var selectedCategory = "{{ $category }}";

        document.querySelectorAll('.sidebar ul li a').forEach(function (item) {
            item.addEventListener('click', function (event) {
                event.preventDefault();
                selectedCategory = event.target.getAttribute('data-value');
                filterProducts();
            });
        });

        function filterProducts() {
            var category = selectedCategory;
            window.location.href = "{{ url('shop') }}?category=" + category;
        }

        function adjustItemsPerRow() {
            var container = document.getElementById("product-container");
            var productElements = container.querySelectorAll(".prdct-wrap");

            productElements.forEach(function (productElement) {
                productElement.classList.remove("col-lg-4", "col-md-6", "col-sm-12");

                if (window.innerWidth >= 992) {
                    productElement.classList.add("col-lg-4");
                } else if (window.innerWidth >= 768) {
                    productElement.classList.add("col-md-6");
                } else {
                    productElement.classList.add("col-sm-12");
                }
            });
        }
        window.addEventListener("resize", adjustItemsPerRow);

        // Ensure correct category is highlighted on page load
        document.querySelectorAll('.sidebar ul li a', '.sidebar ul li').forEach(function (item) {
            if (item.getAttribute('data-value') === selectedCategory) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    </script>

</body>

</html>