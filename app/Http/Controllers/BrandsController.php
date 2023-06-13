<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::OrderBy('created_at', 'desc')
            ->paginate(1);
        return view('Admin.Brands.brands-index', [
            'brands' => $brands,
        ]);

    }
    public function filter(Request $request)
    {
        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $status = $request->status ?? ['Active', 'Inactive'];
        $sort = $request->sort ?? 'newest';
        $query = Brand::query();

        // Apply the filters
        if (!empty($minDate)) {
            $query->where('created_at', '>=', $minDate);
        }

        if (!empty($maxDate)) {
            $query->where('created_at', '<=', $maxDate);
        }

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }

        if (!empty($status)) {
            $query->whereIn('status', $status);
        }

        // if (is_array($status) && count($status) > 0) {
        //     $query->whereIn('status', $status);
        // }

        // Apply the order by clause
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
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
            'logo' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg,svg'],
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
            'logo' => ['file', 'image', 'mimes:jpeg,jpg', 'max: 1024000'],
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
        $result = Brand::destroy($id);
        if ($result) {
            return redirect()->route('admin.brands.index')->with('success', 'Brand Deleted Successfully');

        } else {
            return redirect()->route('admin.brands.index')->with('error', 'Brand Cannot be Deleted ');
        }
    }
}
