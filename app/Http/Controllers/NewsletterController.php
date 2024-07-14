<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
{
    \Log::info('Request data:', $request->all());

    $request->validate([
        'email' => 'required|email|unique:newsletters,email',
    ]);

    Newsletter::create([
        'email' => $request->email,
    ]);

    return redirect()->back()->with('success', 'Subscribed successfully!');
}
}

