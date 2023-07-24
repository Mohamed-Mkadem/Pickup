<?php

namespace App\Http\Controllers;

use App\Models\Expensable;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    protected $categories = [
        'admin' => [
            'Operating Costs', 'Vouchers Creation',
        ],
        'seller' => [
            'Operating Costs', 'Order Cancellation', 'Subscriptions Purchase',
        ],
    ];
    /**
     * Display a listing of the resource.
     */

    public function index()
    {

        $user = User::findOrFail(Auth::id());
        $expenses = Expense::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate();
        $expense = Expense::first();
        // dd($expense->expensable->id);
        if ($user->isSeller()) {
            return view('Seller.seller-expenses', ['expenses' => $expenses, 'categories' => $this->categories]);
        }

        return view('Admin.expenses', ['expenses' => $expenses, 'categories' => $this->categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function filter(Request $request)
    {
        $user = Auth::user();
        $query = Expense::query();
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

        $expenses = $query->paginate();
        if ($user->type == 'Seller') {
            return view('Seller.seller-expenses', ['expenses' => $expenses, 'categories' => $this->categories]);
        }
        return view('Admin.expenses', ['expenses' => $expenses, 'categories' => $this->categories]);
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
            $expensable = Expensable::create();
            $expense = Expense::create([
                'expensable_type' => get_class($expensable),
                'expensable_id' => $expensable->id,
                'user_id' => $user->id,
                'amount' => $request->amount,
                'description' => $request->description,
                'title' => $request->title,
                'category' => $request->category,

            ]);
            return redirect()->back()->with('success', 'Expense Added Successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something Went Wrong, Please Try Later');
            // throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $this->authorize('update', $expense);
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
            $expense->update([
                'amount' => $request->amount,
                'description' => $request->description,
                'title' => $request->title,
                'category' => $request->category,

            ]);
            return redirect()->back()->with('success', 'Expense Updated Successfully');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error', 'Something Went Wrong, Please Try Later');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $this->authorize('update', $expense);
        if ($expense->expensable instanceof Expensable) {
            $result = $expense->delete();
            if ($result) {
                return redirect()->back()->with('success', 'Expense Deleted Successfully');
            }
            return redirect()->back()->with('error', 'Oops Something Went Wrong!');
        }
        $class = class_basename(get_class($expense->expensable));
        return redirect()->back()->with('error', "Cannot Remove The Dynamically Added Expenses, If you Want to remove this expense You have to delete the {$class} number {$expense->expensable->id}");

    }
}
