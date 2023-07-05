<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\VoucherCategory;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    // function use (Request $request) {

    //     $validatedData = Validator::make($request->all(), [
    //         'code' => ['required', 'numeric', 'digits:14'],
    //     ]);
    //     $voucher = Voucher::findOrFail($request->code);
    //     // Add condition to validate that the voucher is unused
    //     $user = Auth::user();
    //     if ($user->type == "Seller") {
    //         $seller = $user->seller;
    //         $seller->update([
    //             'balance' => DB::raw('balance + ' . $voucher->value),
    //         ]);
    //         return redirect()->route('seller.balance')->with('success', 'Added successfully');
    //     } elseif ($user->type == "Client") {
    //         $client = $user->client;
    //         dd($client);
    //     }
    //     return redirect()->back();
    // }

    public function index()
    {
        $vouchersCategories = VoucherCategory::all();
        $vouchers = Voucher::paginate();

        return view('Admin.Vouchers.vouchers-index', ['vouchers' => $vouchers, 'vouchersCategories' => $vouchersCategories]);
    }
    public function create()
    {
        $vouchersCategories = VoucherCategory::all();
        return view('Admin.Vouchers.vouchers-create', ['vouchersCategories' => $vouchersCategories]);
    }
    public function check()
    {
        return view('Admin.Vouchers.vouchers-check');
    }
    public function show(Request $request)
    {
        // dd($request->id);

        $request->validate([
            'id' => ['required'],
        ]);

        $voucher = Voucher::findOrFail($request->id);

        if ($voucher) {
            return response()->json([
                'voucher' => $voucher,
            ], 200);
        } else {
            return response()->json([
                'missing' => 'voucher not exist',
            ], 404);

        }

        dd($voucher);

        // return view('Admin.Vouchers.vouchers-check', ['voucher' => $voucher]);
    }
    public function store(Request $request)
    {

        // $code = Str::random(14);

        $request->validate([
            'category_id' => ['required', 'exists:voucher_categories,id'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'cost' => ['required', 'numeric'],
            'price' => ['required', 'numeric', 'gt:cost'],
        ]);
        $category = VoucherCategory::findOrFail($request->category_id);
        // Generate a unique voucher code
        for ($i = 0; $i < $request->quantity; $i++) {

            $code = rand(00000000000000, 99999999999999);

            // Check if the voucher code already exists in the database
            while (Voucher::where('code', $code)->exists()) {
                // Regenerate the voucher code

                $code = rand(00000000000000, 99999999999999);
            }
            Voucher::create([
                'category_id' => $request->category_id,
                'cost' => $request->cost,
                'price' => $request->price,
                'value' => $category->value,
                'code' => $code,
            ]);
        }

        return response()->json([
            'success' =>
            $request->quantity == 1 ? '1 Voucher Added Successfully' : $request->quantity . ' Vouchers Added Successfully',
        ], 200);

    }

    public function filter(Request $request)
    {
        $vouchersCategories = VoucherCategory::all();
        $query = Voucher::query();
        $minValue = $request->min_value ?? '';
        $maxValue = $request->max_value ?? '';
        $mindate = $request->min_date ?? '';
        $maxdate = $request->max_date ?? '';
        $sort = $request->sort ?? 'newest';
        $status = $request->status ?? ['used', 'unused'];
        $category_id = $request->category_id ?? 'all';
        // dd($sort);
        if (!empty($minValue)) {
            $query->where('value', '>=', $minValue);
        }
        if (!empty($maxValue)) {
            $query->where('value', '<=', $maxValue);
        }
        if (!empty($mindate)) {
            $query->where('created_at', '>=', $mindate);
        }
        if (!empty($maxDate)) {
            $maxDateTime = \Carbon\Carbon::parse($maxDate)->endOfDay();
            $query->where('created_at', '<=', $maxDateTime);
        }
        if ($sort == 'highest') {
            $query->orderBy('value', 'desc');
        } elseif ($sort == 'lowest') {
            $query->orderBy('value', 'asc');

        } elseif ($sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort == 'oldest') {
            $query->orderBy('created_at', 'asc');

        }

        if ($category_id != "all") {
            $query->where('category_id', $category_id);
        }
        $query->whereIn('status', $status);
        $vouchers = $query->paginate();

        return view('Admin.Vouchers.vouchers-index', ['vouchers' => $vouchers, 'vouchersCategories' => $vouchersCategories]);
    }

}
