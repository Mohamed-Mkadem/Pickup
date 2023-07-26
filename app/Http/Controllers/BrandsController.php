<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BrandsController extends Controller
{

    public function index()
    {

        $brands = Brand::with('products')->orderBy('created_at', 'desc')
            ->paginate();
        return view('Admin.Brands.brands-index', [
            'brands' => $brands,
        ]);

    }
    public function filter(Request $request)
    {
        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $status = $request->status ?? [];
        $sort = $request->sort ?? 'newest';
        $minProducts = $request->min_products ?? '';
        $maxProducts = $request->max_products ?? '';
        $query = Brand::query();

        // Apply the filters
        if (!empty($minDate)) {
            $query->where('created_at', '>=', $minDate);
        }

        if (!empty($maxDate)) {
            $maxDateTime = \Carbon\Carbon::parse($maxDate)->endOfDay();
            $query->where('created_at', '<=', $maxDateTime);
        }

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }

        if (!empty($status)) {
            $query->whereIn('status', $status);
        }

        $query->select('brands.*')
            ->addSelect(DB::raw('(SELECT COUNT(*) FROM products WHERE products.brand_id = brands.id) AS products_count'));

// Apply the filter by minimum and maximum products
        if (!empty($minProducts)) {
            $query->having('products_count', '>=', $minProducts);
        }

        if (!empty($maxProducts)) {
            $query->having('products_count', '<=', $maxProducts);
        }

// Apply the order by clause
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'highest_products') {
            $query->orderBy('products_count', 'desc');
        } elseif ($sort === 'lowest_products') {
            $query->orderBy('products_count', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        // dd($query);
        $brands = $query->paginate();
        return view('Admin.Brands.brands-index', ['brands' => $brands]);

    }
    public function create()
    {

        return view('Admin.Brands.brands-create');
    }
    public function show($id)
    {
        $brand = Brand::findOrFail($id);
//    dd($brand);
        return view('Admin.Brands.brands-show', ['brand' => $brand]);
    }
    public function store(Request $request)
    {
        // dd($request);
        $validatedData = Validator::make($request->all(), [
            'name' => ['required', 'string', 'unique:brands', 'max:255'],
            'status' => ['required', 'in:Active,Inactive'],
            'description' => ['required', 'string'],
            'logo' => ['required', 'file', 'image', 'mimes:jpeg,jpg', 'max:1024', Rule::dimensions()->height(256)->width(256)],
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
        } else {

            $file = $request->logo;
            $path = $file->store('/brands', [
                'disk' => 'public',
            ]);

            Brand::create([
                'name' => $request->name,
                'logo' => $path,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            return redirect()->back()->with('success', 'Brand Added Successfully');
        }
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('Admin.Brands.brands-edit', [
            'brand' => $brand,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('brands', 'name')->ignore($id)],
            'status' => ['required', 'in:Active,Inactive'],
            'description' => ['required', 'string'],
            'logo' => ['file', 'image', 'mimes:jpeg,jpg', 'max:1024', Rule::dimensions()->height(256)->width(256)],
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()
                ->withErrors($validatedData)
                ->withInput();
        } else {
            $path = null;
            if ($request->hasFile('logo')) {

                $file = $request->logo;
                $path = $file->store('/brands', [
                    'disk' => 'public',
                ]);
            }
            $brand = Brand::findOrFail($id);
            if ($brand) {

                $brand->update([
                    'name' => $request->name,
                    'logo' => $path ? $path : $brand->logo,
                    'description' => $request->description,
                    'status' => $request->status,
                ]);
            }

            return redirect()->back()->with('success', 'Brand Updated Successfully');
        }
    }
    public function destroy($id)
    {
        $brand = Brand::findOrfail($id);

        if ($brand->productsCount() > 0) {
            return redirect()->back()->with('error', 'Brands That Have Products Cannot Be Deleted, You can Desactivate It Instead To Prevent Sellers From Using It ');

        } else {
            $brand->delete();
            return redirect()->back()->with('success', 'Brand Deleted Successfully');
        }
    }
}
