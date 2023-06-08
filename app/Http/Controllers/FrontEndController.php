<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class FrontEndController extends Controller
{
    public function home(){
        return view('Front_End.home');
    }
    public function about(){
        return view('Front_End.about');
    }
    public function contact(){
        return view('Front_End.contact');
    }
    public function trackOrder(){
        return view('Front_End.trackOrder');
    }
    public function privacy(){
        return view('Front_End.privacy');
    }
    public function terms(){
        return view('Front_End.terms');
    }
    public function faqs(){
        return view('Front_End.faqs');
    }
    public function startSelling(){
        return view('Front_End.startSelling');
    }
    public function sendEmail(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        Mail::to('mkademhamma19@gmail.com')->send(new ContactFormMail($data));

        return redirect()->back()->with('success', 'Thank you for your message!');
    }
}
