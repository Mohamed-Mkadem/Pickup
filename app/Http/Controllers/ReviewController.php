<?php

namespace App\Http\Controllers;

use App\Events\ReviewCreated;
use App\Events\ReviewDeleted;
use App\Models\Order;
use App\Models\Review;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $store = Store::where('seller_id', Auth::user()->seller->id)->firstOrFail();
        $reviews = Review::where('store_id', $store->id)->with(['client', 'order', 'client.user'])->paginate();

        return view('Seller.reviews', ['reviews' => $reviews, 'store' => $store]);
    }

    public function filter(Request $request)
    {
        $store = Store::where('seller_id', Auth::user()->seller->id)->firstOrFail();

        $query = Review::query();
        $query->where('store_id', $store->id);
        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $sort = $request->sort ?? 'newest';
        $min_rate = $request->min_rate ?? '';
        $max_rate = $request->max_rate ?? '';
        if (!empty($minDate)) {
            $query->where('created_at', '>=', $minDate);
        }

        if (!empty($maxDate)) {
            $maxDateTime = \Carbon\Carbon::parse($maxDate)->endOfDay();
            $query->where('created_at', '<=', $maxDateTime);
        }
        if (!empty($min_rate)) {
            $query->where('total', '>=', $min_rate);
        }

        if (!empty($max_rate)) {
            $query->where('total', '<=', $max_rate);
        }
        if (!empty($search)) {
            $query->wherehas('order', function ($subQuery) use ($search) {
                $subQuery->where('id', 'like', "%$search%");

            });
        }
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'highest rate') {
            $query->orderBy('total', 'desc');
        } elseif ($sort === 'lowest rate') {
            $query->orderBy('total', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $reviews = $query->with(['client', 'order', 'client.user'])->paginate();

        return view('Seller.reviews', ['reviews' => $reviews, 'store' => $store]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {

        $order = Order::where('client_id', Auth::user()->client->id)->findOrFail($id);
        $store = $order->store;
        $validation = Validator::make($request->all(), [
            'honesty' => ['required', 'numeric', 'between:1,5'],
            'hospitality' => ['required', 'numeric', 'between:1,5'],
            'commitment' => ['required', 'numeric', 'between:1,5'],
            'feedback' => ['nullable', 'string', 'max:120'],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        try {
            DB::beginTransaction();
            $anonymous = $request->anonymous ? true : false;
            $review = Review::create([
                'order_id' => $order->id,
                'store_id' => $store->id,
                'client_id' => $order->client->id,
                'honesty' => $request->honesty,
                'hospitality' => $request->hospitality,
                'commitment' => $request->commitment,
                'feedback' => $request->feedback ?? null,
                'anonymous' => $anonymous,
                'total' => (($request->honesty + $request->hospitality + $request->commitment) / 15) * 100,
            ]);
            $store->updateRate();
            event(new ReviewCreated($review));
            DB::commit();
            return redirect()->back()->with('success', 'Review Added Successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $this->authorize('update', $review);

        $validation = Validator::make($request->all(), [
            'feedback' => ['nullable', 'string', 'max:120'],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $anonymous = $request->anonymous ? true : false;
        $review->update([
            'feedback' => $request->feedback ?? null,
            'anonymous' => $anonymous,
        ]);
        return redirect()->back()->with('success', 'Review Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $review = Review::with('store')->findOrFail($id);
        $this->authorize('delete', $review);
        $store = $review->store;
        $order = $review->order;
        try {
            DB::beginTransaction();
            $review->delete();
            $store->updateRate();
            // Event, send the order
            event(new ReviewDeleted($order));
            DB::commit();
            return redirect()->back()->with('success', 'Review Deleted Successfully Successfully');
        } catch (\Throwable $th) {
            throw $th;
        }

    }
}
