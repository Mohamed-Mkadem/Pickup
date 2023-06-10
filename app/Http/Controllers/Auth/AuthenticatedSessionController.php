<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request): View
    {
        if( $request->is('seller/login') ){
            return view('Seller.login')  ;
        } elseif($request->is('admin/login')){
            return view('Admin.login')  ;

        }else{
            return view('Client.login');
        }
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
    
        if(Auth()->user()->type == 'Client'){
          
            return redirect()->intended(RouteServiceProvider::CLIENT_HOME);
        }
        elseif(Auth()->user()->type == 'Seller'){
            return redirect()->intended(RouteServiceProvider::SELLER_HOME);
        }
        if(Auth()->user()->type == 'Admin'){
            return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
