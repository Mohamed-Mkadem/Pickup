<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\VoucherCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VouchersCategoriesController extends Controller
{
    public function index()
    {
        $vouchersCategories = VoucherCategory::withCount('vouchers')->orderBy('created_at', 'desc')->paginate();

        return view(
            'Admin.Vouchers.vouchers-categories',
            [
                'vouchersCategories' => $vouchersCategories,
            ]
        );
    }

    public function filter(Request $request)
    {
        $query = VoucherCategory::query();
        $search = $request->search ?? '';
        $minValue = $request->min_value ?? '';
        $maxValue = $request->max_value ?? '';
        $mindate = $request->min_date ?? '';
        $maxdate = $request->max_date ?? '';
        $sort = $request->sort ?? 'newest';
        $minVouchers = $request->min_vouchers ?? '';
        $maxVouchers = $request->max_vouchers ?? '';
        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }

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
        if (!empty($minVouchers)) {
            $query->whereHas('vouchers', function ($subQuery) use ($minVouchers) {
                $subQuery->havingRaw('COUNT(*) >= ?', [$minVouchers]);
            });
        }
        if (!empty($maxVouchers)) {
            $query->whereHas('vouchers', function ($subQuery) use ($maxVouchers) {
                $subQuery->havingRaw('COUNT(*) <= ?', [$maxVouchers]);
            });
        }
        $vouchersCategories = $query->withCount('vouchers')->paginate();

        return view(
            'Admin.Vouchers.vouchers-categories',
            [
                'vouchersCategories' => $vouchersCategories,
            ]
        );

    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:voucher_categories'],
            'icon' => ['required', 'image', 'mimes:jpeg,jpg', 'max:1024', Rule::dimensions()->height(256)->width(256)],
            'value' => ['required', 'numeric', 'min:1'],
        ]);
        // dd($request->icon);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        } else {
            $file = $request->file('icon');
            $path = $file->store('/vouchers_categories', [
                'disk' => 'public',
            ]);
            VoucherCategory::create([
                'name' => $request->name,
                'icon' => $path,
                'value' => $request->value,
            ]);

            return redirect()->back()->with('success', 'Voucher Category Added Successfully');
        }
    }
    public function update(Request $request, $id)
    {
        $voucherCategory = VoucherCategory::findOrFail($id);
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('voucher_categories', 'name')->ignore($voucherCategory->id)],
            'icon' => ['required', 'image', 'mimes:jpeg,jpg', 'max:1024', Rule::dimensions()->height(256)->width(256)],

        ]);
        // dd($request->icon);
        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        } else {
            $path = null;
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $path = $file->store('/vouchers_categories', [
                    'disk' => 'public',
                ]);
            };
            $voucherCategory->update([
                'name' => $request->name,
                'icon' => $path ? $path : $voucherCategory->icon,

            ]);

            return redirect()->back()->with('success', 'Voucher Category Updated Successfully');
        }

    }
    public function destroy($id)
    {
        $voucherCategory = VoucherCategory::findOrFail($id);

        if ($voucherCategory->vouchersCount() > 0) {
            return redirect()->back()->with('error', 'Vouchers Categories That Have Vouchers Cannot Be Deleted');

        }
        $voucherCategory->delete();
        return redirect()->back()->with('success', 'Voucher Category Deleted Successfully');
    }
}
