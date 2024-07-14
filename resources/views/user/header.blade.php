<!DOCTYPE html>
<html>

<head>
    @extends('Admin.layout')
    <title>@yield('title')</title>
    <link href="{{ asset('/css/header.css') }}" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('/logo/R_logo_2.jpg') }}">
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-black fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="">
                <img class="img_size" src="{{ asset('/logo/R_chrome.png') }}" alt="Rager">
            </a>
            <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dark offcanvas</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="/home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('shop*') ? 'active' : '' }}" href="/shop">Shop</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('catalog*') ? 'active' : '' }}" href="/catalogs">Catalog</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="shop-cart">
                <div class="dropdown">
                    <a href="{{ route('user.cart') }}">
                        <div class="cart-dd" type="button">
                            <div class="cart-icon">
                                <i class="ti ti-shopping-bag"></i>
                            </div>
                            <span class="cart-cnt">{{ count((array) session('cart')) }}</span>
                        </div>
                    </a>
                    <div class="card dropdown-menu">
                        @php
                            $total = 0;
                            $cart = session('cart', []);
                            foreach ($cart as $id => $details) {
                                $total += $details['price'] * $details['quantity'];
                            }
                        @endphp
                        @if(!empty($cart))
                            @foreach($cart as $id => $details)
                                <div class="row-cart-detail item-cont mb-4">
                                    <div class="d-flex item-wrap justify-content-center">
                                        <div class="d-flex" style="padding: 2vh 10vh;">
                                            <div class="cart-smol-img">
                                                <img src="{{ asset('storage/' . $details['image1']) }}"
                                                    alt="{{ $details['item_name'] }}" style="width:10vh; height:10vh;" />
                                            </div>
                                            <div class="nameNprice">
                                                <div class="d-flex justify-content-start align-items-center">
                                                    {{ $details['item_name'] }}
                                                </div>
                                                <div class="d-flex justify-content-start align-items-center"
                                                    style="font-weight:300">${{ number_format($details['price'], 2) }} X
                                                    {{ $details['quantity'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="mb-2">
                                <hr class="border border-dark border-1 opacity-45">
                                <div class="d-flex justify-content-center align-items-start">
                                    <a class="view-all" href="{{ route('user.cart') }}" class="btn btn-link">View all</a>
                                </div>
                            </div>
                        @else
                            <div class="wen-emt" style="padding: 2vh 30vh;">
                                <div>
                                    <div class="d-flex justify-content-center align-items-center emt-icon">
                                        <i class="ti ti-mood-empty"></i>
                                    </div>
                                    <div class="d-flex justify-content-center ">
                                        <p>NoProductsYet</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </nav>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let navbar = document.querySelector('.navbar');
            let lastScrollTop = 0;

            window.addEventListener('scroll', function () {
                let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > lastScrollTop && scrollTop > 10) {
                    navbar.style.top = '-100px';
                } else {
                    navbar.style.top = '0';
                }
                lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
            });
        });
    </script>
</body>

</html>
