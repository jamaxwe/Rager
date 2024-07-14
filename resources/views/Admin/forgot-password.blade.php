
<!-- Form to request password reset -->
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div>
        <label for="email">Email Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <span>{{ $message }}</span>
        @enderror
    </div>
    <div>
        <button type="submit">Send Password Reset Link</button>
    </div>
</form>