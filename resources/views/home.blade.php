<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rager - Home</title>
  <link href="{{ asset('/css/Home.css') }}" type="text/css" rel="stylesheet">
  @include('user.header')
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
  <div class="sec-slide sec_1">
    <div class="contain">
      <div class="container-fluid vid">
        <video src="video/R_video.mp4" muted="muted" loop="loop" autoplay="autoplay"></video>
        <div class="container-fluid cont">
          <h1>EXPRESSING THE RAGE IN A COLD WAY.</h1>
        </div>
      </div>
    </div>
  </div>
  
  <section id="new-arrivals" style="background-image:url('/images/runbg.jpg')">
    <div class="bgcolor">
      <div class="container">
        <h2 style="padding:3vh 0vh; color:white;">New Releases</h2>
        @if($newReleases->isEmpty())
      <div class="alert alert-info">
        No new releases available.
      </div>
    @else
    <div class="row">
      @foreach($newReleases as $release)
      <div class="col-md-3">
      <div class="card" style="border:0; border-radius:0px; opacity: 0.85;">
      <div class="img-size d-flex justify-content center">
      <a href="">
        <img src="{{ asset('storage/' . $release->image1) }}" class="card-img-top"
        style="width: 100%; height: auto;" alt="{{ $release->name }} Image">
      </a>
      </div>
      </div>
      <div class="d-flex justify-content-center mb-4 mt-2">
      <div>
      <div class="d-flex justify-content-center name">
        <a href="{{ route('user.preview', ['product' => $release->id]) }}">{{ $release->item_name }}</a>
      </div>

      <div class="d-flex justify-content-center price">
        ₱{{ number_format($release->price, 2) }}
      </div>
      </div>
      </div>
      </div>
    @endforeach
      <div class="col-md-4">
      <div class=" shop-now">
        <a class="btn btn-shop" href="/shop">Shop Now</a>
      </div>
      </div>
    </div>
  @endif
      </div>
    </div>
  </section>

  <section id="info" class="d-flex align-items-center">
    <div class="row no-gutters">
      <div class="info-item col-lg-4 col-md-12 ">
        <i class="fa-solid fa-truck-fast"></i>
        <h5>Nationwide Shipping</h5>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Corrupti dignissimos odio voluptatibus. Quis
          voluptas ipsum, assumenda fuga aliquid non exercitationem!</p>
      </div>
      <div class="info-item col-lg-4 col-md-12 ">
        <i class="fa-regular fa-money-bill-1"></i>
        <h5>Secure Payment</h5>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Magni officiis sed voluptatibus.</p>
      </div>
      <div class="info-item col-lg-4 col-md-12 ">
        <i class="fa-solid fa-right-left"></i>
        <h5>Return Policy</h5>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Accusantium repellat dignissimos qui, fugiat
          nesciunt aliquid consectetur odit commodi tempore?</p>
      </div>
    </div>
  </section>

  @if($topProducts->isEmpty())
    <div></div>
  @else
    <section id="top-products" style="background-image:url('/images/starbg.jpg')">
    <div class="bgcolor2">
      <div class="container">
      <h2 style="padding:3vh 0vh; color:white;">Top Products</h2>
      <div class="row">
        @foreach($topProducts as $orderItem)
      @if($orderItem->product) <!-- Check if the product exists -->
      <div class="col-md-4">
      <div class="card card2" style="border:0; border-radius:20px; opacity: 0.85;">
      <div class="img-size d-flex justify-content-center">
      <a href="">
      <img src="{{ asset('storage/' . $orderItem->product->image1) }}" class="card-img-top"
      style="width: 100%; height: auto;" alt="{{ $orderItem->product->item_name }} Image">
      </a>
      </div>
      </div>
      <div class="d-flex justify-content-center mb-4 mt-2">
      <div>
      <div class="d-flex justify-content-center name">
      <a
      href="{{ route('user.preview', ['product' => $orderItem->product->id]) }}">{{ $orderItem->product->item_name }}</a>
      </div>

      <div class="d-flex justify-content-center price">
      ₱{{ number_format($orderItem->product->price, 2) }}
      </div>
      </div>
      </div>
      </div>
    @else
      <div class="col-md-4">
      <div class="card mb-4 shadow-sm">
      <img src="{{ asset('path/to/default/image.jpg') }}" class="card-img-top"
      style="width: 100%; height: auto;" alt="Default Image">
      <div class="card-body">
      <h5 class="card-title">Product not found</h5>
      <p class="card-text">Total Quantity Sold: {{ $orderItem->total_quantity }}</p>
      </div>
      </div>
      </div>
    @endif
    @endforeach
      </div>
@endif
      </div>
    </div>
  </section>

  <section id="about-rager">
    <div class="row no-gutters">
      <div class="col-lg-6 col-md-12"
        style="height:70vh; display: flex; align-items: center; justify-content: center; overflow: hidden;">
        <img src="/images/RAGE.png" alt="" class="img-fluid fill-div-image" style="opacity:0.7">
      </div>
      <div class="text-cont col-lg-6 col-md-12"
        style="min-height:70vh; background-image:url('/preview-model/ragerger.png')">
        <div class="about-wrap d-flex justify-content-center align-items-center">
          <div class="container">
            <h2>About Rager</h2>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Culpa ipsa voluptatibus modi. Illo sunt,
              laborum nulla numquam, ipsum quod recusandae minus similique tenetur, autem exercitationem possimus fugit
              adipisci voluptates ex.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  

  <section id="connection">
    <div class="container d-flex flex-column justify-content-center align-items-center" style="height:40vh">
      <div class="row no no-gutters">
        <h2 class="d-flex justify-content-center col-md-12">Subsribe to our newsletter</h2>
        <div class="news-cont d-flex flex-column justify-content-center col-md-12">
        <form class="form-mail" action="{{ route('newsletter.subscribe') }}" method="POST">
    @csrf
    <input type="email" name="email" placeholder="Email Address">
    <button type="submit" class="btn-sub">
        <i class="fa fa-paper-plane"></i>
    </button>
</form>

          <div class="p-2" style="text-align:center">
            Follow us!
            <div class="icons">
              <i class="fa-brands fa-facebook-f"></i><span>Rager</span>&nbsp;&nbsp;&nbsp;
              <i class="fa-brands fa-instagram"></i><span>rager.kta</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <footer>
    @include('user.footerbtm')
  </footer>
</body>

</html>