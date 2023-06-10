<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{
    public function home(){
        return view('Seller.home');
    }
    public function profile(){
        return view('seller.profile');
    }
}
