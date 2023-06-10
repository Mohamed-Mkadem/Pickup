<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\State;
use App\Models\Client;
use App\Models\Seller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    protected $userType = 'client';

    public function __construct(Request $request)
    {
         $request->type === 'seller' ? $this->userType = 'seller' : $this->userType = 'client';
         
    }
        
        /**
         * Display the registration view.
         */
        public function create(Request $request): View
        {
            $states = State::with('cities')->get();
            if($request->is('register')){
                return view('auth.register',['states' => $states]);
                
        }else if($request->is('seller/register')){
            return view('auth.seller-register',['states' => $states]);
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // don't forget to validate state / city
        $data = $request->all();
        $customAttributes = [
            'state_id' => 'State',
            'city_id' => 'City',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'd_o_b' => 'Date Of Birth',
            'nid' => 'National ID Number',
            'rib' => 'RIB Number',
            'bank' => 'Bank',
            'account_name' => 'Bank Account Name',
        ];
        if($request->type == 'client'){
            $validator = Validator::make($data, [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'd_o_b' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
                'phone' => ['required', 'digits:8','unique:users'],
                'state_id' => ['required', 'exists:states,id'],
                    'city_id' => [
                        'required',
                        Rule::exists('cities', 'id')->where(function ($query) use ($request) {
                            $query->where('state_id', $request->state_id);
                        }),
                    ],
                'address' => ['required'],
                'gender' => ['required', 'in:Male,Female'],
            ], [], $customAttributes);
            
            if ($validator->fails()) {
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            } else {
                // Validation passed
                // Proceed with storing the user
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address' => $request->address,
                   
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'd_o_b' => $request->d_o_b,
                    'type' => $request->type,
                    'email' => $request->email,
                    'state_id' => $request->state_id,
                    'city_id' => $request->city_id,
                    'password' => Hash::make($request->password),
                ]);
                if($user){
                    Client::create([
                        'user_id' => $user->id
                    ]);
                }
                
            }
        }
        if($request->type == 'seller'){
            $validator = Validator::make($data, [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'd_o_b' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
                'phone' => ['required', 'digits:8','unique:users'],
                'state_id' => ['required', 'exists:states,id'],
                'city_id' => [
                    'required',
                    Rule::exists('cities', 'id')->where(function ($query) use ($request) {
                        $query->where('state_id', $request->state_id);
                    }),
                ],
                'address' => ['required'],
                'gender' => ['required', 'in:Male,Female'],
                'bank' => ['required'],
                'account_name' => ['required'],
                'rib' => ['required', 'digits:20', 'unique:sellers'],
                'nid' => ['required', 'digits:8', 'unique:sellers'],
            ], [], $customAttributes);
            
            if ($validator->fails()) {
                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            } else {
                // Validation passed
                // Proceed with storing the user
                $user = User::create([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address' => $request->address,
                    'state_id' => $request->state_id,
                    'city_id' => $request->city_id,
                    'gender' => $request->gender,
                    'phone' => $request->phone,
                    'd_o_b' => $request->d_o_b,
                    'type' => $request->type,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                if($user){
                    Seller::create([
                        'user_id' => $user->id,
                        'bank' => $request->bank,
                        'account_name' => $request->account_name,
                        'rib' => $request->rib,
                        'nid' => $request->nid,
                    ]);
                }
                
            }
        }

  
     
   

        event(new Registered($user));

        Auth::login($user);
   
        if(Auth::user()->type == 'client'){
           
            return redirect(RouteServiceProvider::CLIENT_HOME);
        }
        elseif(Auth::user()->type == 'seller'){
            return redirect(RouteServiceProvider::SELLER_HOME);
        }
        if(Auth::user()->type == 'admin'){
            return redirect(RouteServiceProvider::ADMIN_HOME);
        }
        
    }
}
