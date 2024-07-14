@extends('Admin.layout')

@section('title', 'Reset Password')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - @yield('title')</title>
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
                        <div class="img" style="background-image:url(/images/DSCF5377.jpg)">
                        </div>
                        <div class="signup-wrap p-4 p-md-5">
                        </div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Reset Password</h3>
                                </div>
                            </div>
                            <div id="resetPass">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div>
                                        <label class="form-label" for="email">Email Address</label>
                                        <input class="form-control" id="email" type="email" name="email" value="{{ $email ?? old('email') }}"
                                            required autofocus>
                                        @error('email')
                                            <span>{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="form-label" for="password">New Password</label>
                                        <input class="form-control" id="password" type="password" name="password" required
                                            autocomplete="new-password">
                                        @error('password')
                                            <span>{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                                        <input class="form-control" id="password_confirmation" type="password" name="password_confirmation"
                                            required autocomplete="new-password">
                                    </div>
                                    <div>
                                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">Reset Password</button>
                                    </div>
                                </form>
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
@endsection