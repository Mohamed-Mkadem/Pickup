<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use App\Models\Revenueable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RevenueController extends Controller
{
    protected $categories = [
        'admin' => [
            'Subscriptions Sale', 'Vouchers Sale', 'Other',
        ],
        'seller' => [
            'Client Order Cancellation', 'Order Placement', 'Sale Placement', 'Other',
        ],
    ];
    /**
     * Display a listing of the resource.
     */

    public function index()
    {

        $user = User::findOrFail(Auth::id());
        $revenues = Revenue::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate();
        $revenue = Revenue::first();

        if ($user->isSeller()) {
            return view('Seller.seller-revenues', ['revenues' => $revenues, 'categories' => $this->categories]);
        }

        return view('Admin.revenues', ['revenues' => $revenues, 'categories' => $this->categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function filter(Request $request)
    {
        $user = Auth::user();
        $query = Revenue::query();
        $query->where('user_id', $user->id);
        $search = $request->search ?? '';
        $category = $request->category ?? 'all';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $minAmount = $request->min_amount ?? '';
        $maxAmount = $request->max_amount ?? '';
        $sort = $request->sort ?? 'newest';

        if ($category != 'all') {
            $query->where('category', $category);
        }

        if (!empty($minDate)) {
            $query->where('created_at', '>=', $minDate);
        }

        if (!empty($maxDate)) {
            $maxDateTime = \Carbon\Carbon::parse($maxDate)->endOfDay();
            $query->where('created_at', '<=', $maxDateTime);
        }

        if (!empty($search)) {
            $query->where('id', 'like', "%$search%");
        }

        if (!empty($minAmount)) {
            $query->where('amount', '>=', $minAmount);
        }
        if (!empty($maxAmount)) {
            $query->where('amount', '<=', $maxAmount);
        }
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        }
        if ($sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        }
        if ($sort == 'highest_amount') {
            $query->orderBy('amount', 'desc');
        }
        if ($sort == 'lowest_amount') {
            $query->orderBy('amount', 'asc');
        }

        $revenues = $query->paginate();
        if ($user->type == 'Seller') {
            return view('Seller.seller-revenues', ['revenues' => $revenues, 'categories' => $this->categories]);
        }
        return view('Admin.revenues', ['revenues' => $revenues, 'categories' => $this->categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user = Auth::user();
        $validation = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string'],
            'description' => ['required', 'string', 'max:300'],
            'amount' => ['required', 'numeric', 'min:0.1'],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        try {
            $revenueable = Revenueable::create();
            $revenue = Revenue::create([
                'revenueable_type' => get_class($revenueable),
                'revenueable_id' => $revenueable->id,
                'user_id' => $user->id,
                'amount' => $request->amount,
                'description' => $request->description,
                'title' => $request->title,
                'category' => $request->category,

            ]);
            return redirect()->back()->with('success', 'Revenue Added Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something Went Wrong, Please Try Later');
            // throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Revenue $revenue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Revenue $revenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $revenue = Revenue::findOrFail($id);
        $this->authorize('update', $revenue);
        $validation = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string'],
            'description' => ['required', 'string', 'max:300'],
            'amount' => ['required', 'numeric', 'min:0.1'],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }
        try {
            $revenue->update([
                'amount' => $request->amount,
                'description' => $request->description,
                'title' => $request->title,
                'category' => $request->category,

            ]);
            return redirect()->back()->with('success', 'Revenue Updated Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something Went Wrong, Please Try Later');
            // throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $revenue = Revenue::findOrFail($id);
        $this->authorize('update', $revenue);
        if ($revenue->revenueable instanceof Revenueable) {
            $result = $revenue->delete();
            if ($result) {
                return redirect()->back()->with('success', 'Revenue Deleted Successfully');
            }
            return redirect()->back()->with('error', 'Oops Something Went Wrong!');
        }
        $class = class_basename(get_class($revenue->revenueable));
        return redirect()->back()->with('error', "Cannot Remove The Dynamically Added Revenues, If you Want to remove this revenue You have to delete the {$class} number {$revenue->revenueable->id}");

    }
}
