@extends('Admin.layout')

@section('title', 'Login')

@section('content')

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory</title>
  <link href="{{ asset('/css/login.css') }}" type="text/css" rel="stylesheet">
  <style>
    #loadingScreen {
      position: fixed;
      width: 100%;
      height: 100%;
      background: white;
      z-index: 9999;
      display: flex;
      justify-content: center;
      align-items: center;
    }
  </style>
</head>

<body style="font-size: 16px; line-height: 1.8;font-weight: normal; background: #f8f9fd; color: lighten(black,50%);">
  <div id="loadingScreen">
    <div class="spinner-border text-primary" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <section class="ftco-section">
    <div class="container lgn-sec">
      <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10">
          <div class="wrap d-md-flex">
            <div class="img" style="background-image:url(images/DSCF5377.jpg)">
            </div>
            <div class="signup-wrap p-4 p-md-5">
              <div class="d-flex">
                <div class="w-100">
                  <h3 class="mb-4">Sign Up</h3>
                </div>
              </div>
              <form action="{{ route('registration.post') }}" method="POST" class="signin-form">
                @csrf
                <div class="form-group mb-2">
                  <label class="form-label">Name</label>
                  <input type="text" class="form-control" placeholder="Enter your name" name="name" required>
                </div>
                <div class="form-group mb-2">
                  <label class="form-label">Email Address</label>
                  <input type="email" class="form-control" placeholder="...@gmail.com" name="email" required>
                </div>
                <div class="form-group mb-2">
                  <label class="form-label">Password</label>
                  <input type="password" class="form-control" placeholder="Enter your password" name="password"
                    required>
                </div>
                <div class="form-group mb-2">
                  <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign up</button>
                </div>
              </form>
              <p class="text-center" style="padding-top:10px;  color: rgba(0, 0, 0, 0.459);">Go back to <a style="text-decoration:none; color:black; font-size: 16px;
    font-weight: 500;" data-toggle="tab" href="#" class="signin-link">Sign in</a></p>
            </div>
            <div class="login-wrap p-4 p-md-5">
              <div class="d-flex">
                <div class="w-100">
                  <h3 class="mb-4">Sign In</h3>
                </div>
              </div>
              <div id="loginForm">
                @if(session('2fa'))
          <div class="reminder">
            <p>We have sent a verification code to (User's Email Address). If you don't see it there, kindly check
            your spam or junk folder.</p>
          </div>
          <br>
          <form method="POST" action="{{ route('admin.verify') }}" class="signin-form">
            @csrf
            <div class="form-group mb-3">
            <label for="code">Verification Code:</label>
            <input type="text" id="code" name="code" class="form-control" required>
            </div>
            <div class="form-group mb-3">
            <button type="submit" class="form-control btn btn-primary rounded submit px-3">Verify Code</button>
            </div>
          </form>
        @else
      <form id="signInForm" action="{{ route('login.post') }}" method="POST" class="signin-form">
        @csrf
        <div class="form-group mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" placeholder="Enter your email" name="email" required>
        </div>
        <div class="form-group mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" placeholder="Enter your password" name="password"
          required>
        </div>
        @if(session()->has('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
        <div class="form-group mb-3">
        <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
        </div>
        <div class="form-group d-md-flex">
        <div class="w-50 text-left">
        </div>
        <div class="ms-auto">
          <a href="#" id="forgotPasswordLink" class="forgot">Forgot Password</a>
        </div>
        </div>
        <br>
        <p class="text-center" style="padding-top:10px;  color: rgba(0, 0, 0, 0.459);">Become an
        administrator.
        <a style="text-decoration:none; color:black; font-size: 16px; font-weight: 500;" class="signup-link"
          href="#">Sign Up</a>
        </p>
      </form>
    @endif
              </div>
              <div id="passwordResetForm" style="display: none;">
                <div class="mb-2">
                  <d class="header"><strong>{{ __('Reset Password') }}</strong>
                </div>

                <div class="body">
                  @if (session('status'))
            <div class="alert alert-success" role="alert">
            {{ session('status') }}
            </div>
          @endif

                  <form id="passwordResetFormInner" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group">
                      <label for="email" class="text-md-right">{{ __('E-Mail Address') }}</label>

                      <div class="mb-5">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                          name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
                      </div>
                    </div>

                    <div class="mt-5">
                      <div class="">
                        <button type="submit" class="btn btn-primary">
                          {{ __('Send Password Reset Link') }}
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
</body>

<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function () {
    const signInForm = document.getElementById('signInForm');
    const passwordResetForm = document.getElementById('passwordResetForm');
    const forgotPasswordLink = document.getElementById('forgotPasswordLink');

    forgotPasswordLink.addEventListener('click', function (event) {
      event.preventDefault();
      signInForm.style.display = 'none';
      passwordResetForm.style.display = 'block';
    });

    // Optional: Add logic to toggle back to sign in form
    const signInLink = document.querySelector('.signin-link');
    signInLink.addEventListener('click', function (event) {
      event.preventDefault();
      signInForm.style.display = 'block';
      passwordResetForm.style.display = 'none';
    });
  });
</script>
<script>
  setTimeout(function () {
    document.getElementById('loadingScreen').style.display = 'none';
  }, 550);
</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const signupLink = document.querySelector('.signup-link');
    const signinLink = document.querySelector('.signin-link');
    const loginWrap = document.querySelector('.login-wrap');
    const signupWrap = document.querySelector('.signup-wrap');
    const bgImage = document.querySelector('.img');
    let isMobile = window.matchMedia("(max-width: 767px)").matches;

    function updateBackgroundPosition() {
      if (isMobile) {
        bgImage.style.transition = 'transform 0.2s ease';
        bgImage.style.transform = loginWrap.classList.contains('active') ? 'translateY(100%)' : 'translateY(0)';
      } else {
        bgImage.style.transition = 'transform 0.2s ease';
        bgImage.style.transform = loginWrap.classList.contains('active') ? 'translateX(100%)' : 'translateX(0)';
      }
    }

    signupLink.addEventListener('click', function (event) {
      event.preventDefault();
      loginWrap.classList.toggle('active');
      signupWrap.classList.toggle('active');
      updateBackgroundPosition();
    });

    signinLink.addEventListener('click', function (event) {
      event.preventDefault();
      loginWrap.classList.toggle('active');
      signupWrap.classList.toggle('active');
      updateBackgroundPosition();
    });

    window.addEventListener('resize', function () {
      isMobile = window.matchMedia("(max-width: 767px)").matches;
      updateBackgroundPosition();
    });
  });
</script>
@endsection