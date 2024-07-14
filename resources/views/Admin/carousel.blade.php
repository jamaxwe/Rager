<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalog - {{ $catalog->title }}</title>
    <link rel="shortcut icon" href="{{ asset('/logo/R_logo_2.jpg') }}">
    <link href="{{ asset('/css/carousel.css') }}" type="text/css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    @extends('Admin.layout')
    @include('user.header')

</head>

<body>
    <nav class="navbar navbar-dark">
        <a class="navbar-brand" href="user.home" style="visibility:hidden;">
            <img class="img_size" src="{{ asset('/logo/R_chrome.png') }}" alt="Rager">
        </a>
    </nav>
    <div class="container mb-5">
        <div class="d-flex flex-column p-3" style="width:100%; text-align:center; ">
            <h2>{{ $catalog->title }}</h2>
            <p>{{ $catalog->date }}</p>
        </div>
        <div class="row no-gutter">
            @auth
                <div class="col-xl-6">
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#addImageModal">
                        Add Image to Carousel
                    </button>
                </div>
            @endauth
            <div class="message-container col-xl-6">
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
        </div>
        <!-- Swiper -->
        <div class="container d-flex justify-content-center" style="width:40%">
            <div class="swiper-container mySwiper">
                <div class="swiper-wrapper">
                    @foreach($images as $img)
                        <div class="swiper-slide">
                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="Image">
                            @auth
                                <div class="cls-btn">
                                    <form action="{{ route('catalogs.deleteImage', ['id' => $img->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirmDelete()">Remove</button>
                                    </form>
                                </div>
                            @endauth
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
    <footer>
        @include('user.footerbtm')
    </footer>
    <!-- Bootstrap and other JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
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