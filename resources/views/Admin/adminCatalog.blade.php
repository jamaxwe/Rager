<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/css/catalog.css') }}" type="text/css" rel="stylesheet">
    <title>Rager - Catalog</title>
    @extends('Admin.layout')
    @include('user.header')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-image: url('/images/whitebg.png');">
    <nav class="navbar navbar-dark">
        <a class="navbar-brand" href="user.home" style="visibility:hidden;">
            <img class="img_size" src="{{ asset('/logo/R_chrome.png') }}" alt="Rager">
        </a>
    </nav>
    <div class="catalog d-flex justify-content-center pt-5 pb-5">
        <h2>Catalogs</h2>
    </div>
    <div class="cont-container pt-5">
        <div class="container">
            <div>
                <div class="row no-gutter">
                    @auth
                        <div class="col-xl-6">
                            <button type="button" class="btn btn-primary mb-4 mt-4" data-bs-toggle="modal"
                                data-bs-target="#addCatalogModal">
                                Add New Catalog
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
                        @if ($errors->any())
                            <div class="alert alert-danger" id="errorMessage">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        <span class="close-btn ms-auto" onclick="closeMessage('errorMessage')"><i
                                                class="fa-solid fa-xmark"></i></span>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                @if($catalogs->isEmpty())
                    <div class="no-item pb-5" style="min-height:100vh;">
                        <div class="no-item-cont">
                            <h1 style="opacity:0.5">No Item Yet</h1>
                        </div>
                    </div>
                @else
                    <div class="row">
                        @foreach($catalogs as $catalog)
                            <div class="col-xl-3 col-md-4 col-sm-12">
                                @auth
                                    <div class="cls-btn">
                                        <form action="{{ route('catalogs.deleteImagecatalog', ['id' => $catalog->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="button-bg">
                                                <button type="submit" class="btn btn-close btn-sm"
                                                    onclick="return confirmDelete()">
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @endauth
                                <a class="img-cont" href="{{ route('catalogs.show', $catalog->id) }}">
                                    <div class="img-size" style="background-color:black">
                                        <div class="img-cover">
                                            <img src="{{ asset('storage/' . $catalog->image_path) }}" alt="Catalog Image"
                                                class="img-fluid">
                                        </div>
                                        <div class="fix-img">
                                            <img src="/images/bk1.png" alt="">
                                        </div>
                                    </div>
                                    <div class="img-info">
                                        <h4 style="font-weight: 900;">{{ $catalog->title }}</h4>
                                        <p>{{ $catalog->date }}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    
                @endif
            </div>
            @auth
                <!-- Modal -->
                <div class="modal fade" id="addCatalogModal" tabindex="-1" role="dialog"
                    aria-labelledby="addCatalogModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="{{ route('catalogs.store') }}" method="POST" enctype="multipart/form-data">

                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="title">Title:</label>
                                        <input type="text" class="form-control" id="title" name="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Date:</label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image:</label>
                                        <input type="file" class="form-control" id="image_path" name="image_path" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>
    <footer>
        @include('user.footerbtm')
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to remove this item?');
        }
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