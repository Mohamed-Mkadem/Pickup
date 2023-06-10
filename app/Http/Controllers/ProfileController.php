<?php

namespace App\Http\Controllers;

use Rules\Password;
use App\Models\User;
use App\Models\State;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

     public  $customAttributes = [
        'state_id' => 'State',
        'city_id' => 'City',
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'd_o_b' => 'Date Of Birth',
        'nid' => 'National ID Number',
        'rib' => 'RIB Number',
        'bank' => 'Bank',
        'account_name' => 'Bank Account Name',
        'photo' => 'Profile Photo'
    ];
    public function edit(Request $request): View
    {
        $states = State::with('cities')->get();
        $userType = $request->user()->type;
        if($userType == 'Client'){

            return view('Client.profile-edit', [
                'user' => $request->user(),
                'states' => $states
            ]);
        }elseif($userType == 'Seller'){
            return view('Seller.profile-edit', [
                'user' => $request->user(),
                'states' => $states
            ]);
            
        }elseif($userType == 'Admin'){
            return view('Admin.profile-edit', [
                'user' => $request->user(),
                'states' => $states
            ]);

        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        dd($request->user());
        $request->user()->fill($request->validated());
        // dd($request->all());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    public function updateBankInfo(Request $request){
        $seller = User::findOrFail(Auth::id())->seller;
        $data =$request->all();
        
        
        $validatedData = Validator::make($data,[
            'bank' => [ 'required',  'string'],
            'account_name' => [ 'required',  'string'],
            'rib' => [ 'required',   'digits:20', Rule::unique('sellers', 'rib')->ignore($seller->id)],   
        ],[],$this->customAttributes);

        if ($validatedData->fails()) {
            return redirect()->back()
            ->withErrors($validatedData)
            ->withInput();
        }
        
        else{
           
         
            $seller->update([
                'bank' => $request->bank,
                'account_name' => $request->account_name,
                'rib' => $request->rib,

            ]);
            
           
        }
        // Update other fields

        // $user->save();

        return redirect()->back()->with('success', 'Bank Information updated successfully');
   
    }
    public function updateSeller(Request $request){
        $user = User::findOrFail(Auth::id());
        $data =$request->all();
       
     
         $validatedData = Validator::make($data,[
             'first_name' => ['min:3','string', 'max:255'],
             'last_name' => ['min:3', 'string', 'max:255'],
              'email' => [ 'string', 'email', 'max:255',Rule::unique('users', 'email')->ignore($user->id)],  
             'd_o_b' => [ 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
             'phone' => [ 'digits:8',Rule::unique('users', 'phone')->ignore($user->id)],
             'state_id' => [ 'exists:states,id'],
             'photo' => ['file',  'mimes:jpg,png,jpeg', 'max: 1024000'],
             'city_id' => [
                         
                         Rule::exists('cities', 'id')->where(function ($query) use ($request) {
                             $query->where('state_id', $request->state_id);
                         }),
             ],
             'address' => ['string'],
             'gender' => [ 'in:Male,Female'],
               'nid' => [ 'digits:8', Rule::unique('sellers', 'nid')->ignore($user->seller->id)],
           
         ],[],$this->customAttributes);
 
         
         if ($validatedData->fails()) {
             return redirect()->back()
             ->withErrors($validatedData)
             ->withInput();
         }
         else{
            $path = null;
             if ($request->hasFile('photo')) {
                 $file = $request->file('photo');
                 $path = $file->store('/profiles_photos',  [
                     'disk' => 'public'
                 ]);
                
                
             }
             if($request->email != $user->email){
              $user->email_verified_at = null;
                 $user->save();
             };
             $user->update([
                 'first_name' => $request->first_name ? $request->first_name : $user->first_name,
                 'last_name' => $request->last_name ? $request->last_name : $user->last_name,
                 'address' => $request->address,
                 'photo' => $path ? $path : $user->photo,
                 'gender' => $request->gender ? $request->gender : $user->gender,
                 'phone' => $request->phone,
                 'd_o_b' => $request->d_o_b ? $request->d_o_b : $user->d_o_b,
                 'email' => $request->email,
                 'state_id' => $request->state_id,
                 'city_id' => $request->city_id,

             ]);
             if($user){
                $user->seller->update([
                    'nid' => $request->nid ? $request->nid : $user->seller->nid
                ]);
             }
            
         }
         return redirect()->back()->with('success', 'Profile updated successfully');
    }
    public function updateClient(Request $request){
        $user = User::findOrFail(Auth::id());
        $data =$request->all();
       
     
         $validatedData = Validator::make($data,[

              'email' => [ 'string', 'email', 'max:255',Rule::unique('users', 'email')->ignore($user->id)],  
           
             'phone' => [ 'digits:8',Rule::unique('users', 'phone')->ignore($user->id)],
             'state_id' => [ 'exists:states,id'],
             'photo' => ['file',  'mimes:jpg,png,jpeg', 'max: 1024000'],
             'city_id' => [
                         
                         Rule::exists('cities', 'id')->where(function ($query) use ($request) {
                             $query->where('state_id', $request->state_id);
                         }),
             ],
             'address' => ['string'],
            
         ],[],$this->customAttributes);
 
         
         if ($validatedData->fails()) {
             return redirect()->back()
             ->withErrors($validatedData)
             ->withInput();
         }
         else{
            $path = null;
             if ($request->hasFile('photo')) {
                 $file = $request->file('photo');
                 $path = $file->store('/profiles_photos',  [
                     'disk' => 'public'
                 ]);
                
                
             }
             if($request->email != $user->email){
              $user->email_verified_at = null;
                 $user->save();
             };
             $user->update([
                
                 'address' => $request->address,
                 'photo' => $path ? $path : $user->photo,
               
                 'phone' => $request->phone,
              
 
                 'email' => $request->email,
                 'state_id' => $request->state_id,
                 'city_id' => $request->city_id,
               
             ]);
         }
         // Update other fields
 
         // $user->save();
 
         return redirect()->back()->with('success', 'Profile updated successfully');
    }
    public function updateAdmin(Request $request){
       
        $user = User::findOrFail(Auth::id());
       $data =$request->all();
      
    
        $validatedData = Validator::make($data,[
            'first_name' => ['string', 'max:255'],
            'last_name' => [ 'string', 'max:255'],
             'email' => [ 'string', 'email', 'max:255',Rule::unique('users', 'email')->ignore($user->id)],  
            'd_o_b' => [ 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'phone' => [ 'digits:8',Rule::unique('users', 'phone')->ignore($user->id)],
            'state_id' => [ 'exists:states,id'],
            'photo' => ['file',  'mimes:jpg,png,jpeg', 'max: 1024000'],
            'city_id' => [
                        
                        Rule::exists('cities', 'id')->where(function ($query) use ($request) {
                            $query->where('state_id', $request->state_id);
                        }),
            ],
            'address' => ['string'],
            'gender' => [ 'in:Male,Female'],
        ],[],$this->customAttributes);

        
        if ($validatedData->fails()) {
            return redirect()->back()
            ->withErrors($validatedData)
            ->withInput();
        }
        else{
           $path = null;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $path = $file->store('/profiles_photos',  [
                    'disk' => 'public'
                ]);
               
               
            }
            if($request->email != $user->email){
             $user->email_verified_at = null;
                $user->save();
            };
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'address' => $request->address,
                'photo' => $path ? $path : $user->photo,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'd_o_b' => $request->d_o_b,

                'email' => $request->email,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
              
            ]);
        }
        // Update other fields

        // $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
