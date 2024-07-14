<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorAuthMail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\AdminLog;

class AuthManager extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function registration()
    {
        return view('admin.registration');
    }

    public function loginpost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if 2FA is enabled for the user
            if ($user->two_factor_enabled) {
                // Generate a random 6-digit code
                $code = mt_rand(100000, 999999);

                // Save the code and its expiry time in the user's record
                $user->two_factor_code = $code;
                $user->two_factor_expires_at = now()->addMinutes(5); // Adjust the expiry time as needed
                $user->save();

                // Send the code via email
                Mail::to($user->email)->send(new TwoFactorAuthMail($code));

                // Set session variable for 2FA
                session(['2fa' => true]);

                return redirect()->route('login');
            }

            // If 2FA is not enabled, proceed to dashboard or intended route
            return redirect()->route('Admin.index');
        }

        // Authentication failed
        return redirect()->route('login')->with('error', 'Email or password is incorrect!');
    }

    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = Auth::user();

        // Check if the provided code matches the stored code and is still valid
        if ($user->two_factor_code == $request->code && now()->lt($user->two_factor_expires_at)) {
            $user->two_factor_code = null;
            $user->two_factor_expires_at = null;
            $user->save();

            // Clear the 2FA session variable
            session()->forget('2fa');

            AdminLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'Logged in',
                'description' => auth()->user()->name . ' Logged in'
            ]);

            return redirect()->route('Admin.index');
        }

        // Verification failed
        return redirect()->route('login')->with('error', 'Invalid or expired verification code.');
    }

    public function registrationpost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8', // Ensure minimum length
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Hash the password
        $user->save();

        return redirect()->route('login')->with('success', 'Registration successful, you may now log in');
    }

    public function logout()
    {
        if (auth()->check()) {
            AdminLog::create([
                'user_id' => auth()->user()->id,
                'action' => 'Logged out',
                'description' => auth()->user()->name . ' Logged out'
            ]);
        }

        Session::flush();
        Auth::logout();

        return redirect()->route('login');
    }

    public function forgotPasswordForm()
    {
        return view('admin.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        // Generate a unique token
        $token = hash_hmac('sha256', Str::random(40), config('app.key'));

        // Store the token in your password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['email' => $user->email, 'token' => $token, 'created_at' => now()]
        );

        // Send the reset link email
        Mail::to($user->email)->send(new ResetPasswordMail($token));

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function showResetForm($token)
    {
        return view('admin.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8', // Ensure minimum length
            'token' => 'required',
        ]);

        // Retrieve the token data
        $tokenData = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        // Check if tokens match
        if (!hash_equals($tokenData->token, $request->token)) {
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        // Check if token has expired (e.g., within 1 hour)
        $tokenCreatedAt = strtotime($tokenData->created_at);
        $tokenExpiryTime = $tokenCreatedAt + (60 * 60); // 1 hour expiry

        if (time() > $tokenExpiryTime) {
            return back()->withErrors(['email' => 'Token has expired.']);
        }

        // Update user's password with bcrypt hashing
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Remove the token from the password_reset_tokens table
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Your password has been reset!');
    }
}
