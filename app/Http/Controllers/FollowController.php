<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Follow;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    // public function follow($id)
    // {

    //     $client = Auth::user()->client;

    //     $store = Store::find($id);
    //     if (!$store || !$client) {
    //         return redirect()->back()->with('error', 'Something Went Wrong!');
    //     }
    //     DB::beginTransaction();

    //     Follow::create([
    //         'store_id' => $store->id,
    //         'client_id' => $client->id,
    //     ]);
    //     $store->followers = DB::raw('followers + 1');
    //     $store->save();
    //     // Event to inform the store owner
    //     DB::commit();
    //     return redirect()->back()->with('success', "Now You Are Following {$store->name}");

    // }
    public function follow(Store $store)
    {
        $client = Auth::user()->client;

        if (!$client) {
            return redirect()->back()->with('error', 'Something Went Wrong!');
        }

        DB::beginTransaction();

        try {
            $this->addFollow($store, $client);

            DB::commit();

            return redirect()->back()->with('success', "Now You Are Following {$store->name}");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong while following the store.' . $e);
        }
    }
    public function unfollow(Store $store)
    {
        $client = Auth::user()->client;

        if (!$store || !$client) {
            return redirect()->back()->with('error', 'Something Went Wrong!');
        }

        DB::beginTransaction();

        $follow = Follow::where('store_id', $store->id)
            ->where('client_id', $client->id)
            ->first();

        if ($follow) {
            $follow->delete();
            $store->decrement('followers');

            DB::commit();
            return redirect()->back()->with('success', "You have unfollowed {$store->name}");
        }

        DB::rollback();
        return redirect()->back()->with('error', 'You are not following this store');
    }
    private function addFollow(Store $store, Client $client)
    {
        Follow::create([
            'store_id' => $store->id,
            'client_id' => $client->id,
        ]);

        $store->increment('followers');
        // Event to inform the store owner
    }
}
