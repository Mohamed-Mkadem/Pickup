<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    // public function sendEmail(Request $request)
    // {
    //     $data = $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'subject' => 'required',
    //         'message' => 'required',
    //     ]);

    //     Mail::to('mkademhamma19@gmail.com')->send(new ContactFormMail($data));

    //     return redirect()->back()->with('success', 'Thank you for your message!');
    // }
}

