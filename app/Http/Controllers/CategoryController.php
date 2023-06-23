<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Store;
use App\Rules\UniqueCategoryNameForStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    protected $messages = [
        'icon.max' => 'The Icon Max Size is 1 MB',
    ];

    public function __construct()
    {
        $this->middleware('hasStore')->only(['index', 'filter']);
    }
    public function filter(Request $request)
    {
        $query = Category::query();
        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $status = $request->status ?? 'all';
        // $minProducts = $request->min_products ?? '';
        // $maxProducts = $request->max_products ?? '';
        $sort = $request->sort ?? 'newest';
        dd($minDate);
        $query->where('store_id', Auth::user()->seller->store->id);

        if (!empty($minDate)) {
            $query->where('created_at', '>=', $minDate);
        }

        if (!empty($maxDate)) {
            $query->where('created_at', '<=', $maxDate);
        }

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }

        if ($status != 'all') {
            $query->where('status', $status);
        }
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
        // Implements Products when you create them
        $categories = $query->paginate();
        return view('Seller.Categories.categories-index', ['categories' => $categories]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::where('store_id', Auth::user()->seller->store->id)->paginate();

        return view('Seller.Categories.categories-index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $store = Store::where('seller_id', Auth::user()->seller->id)->first();
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:80', new UniqueCategoryNameForStore($store->id)],
            'status' => ['required', 'in:active,inactive'],
            'icon' => ['image', 'mimes:jpeg,jpg', 'max:1024'],
        ], [], $this->messages);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        } else {
            $path = null;
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $path = $file->store('/categories', [
                    'disk' => 'public',
                ]);
            }
            $category = new Category;

            $category->name = $request->name;
            $category->store_id = $store->id;
            $category->status = $request->status;
            if ($path) {
                $category->icon = $path;
            }
            $category->save();

            return redirect()->back()->with('success', 'Category Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        // if (!$category) {
        //     return redirect()->back()->with('error', 'Cannot Update This Category ');
        // }
        $this->authorize('update', $category);
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:80',
                new UniqueCategoryNameForStore($category->store_id, $category->id)],
            'status' => ['required', 'in:active,inactive'],
            'icon' => ['image', 'mimes:jpeg,jpg', 'max:1024'],
        ], [], $this->messages);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        } else {
            $path = null;
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $path = $file->store('/categories', [
                    'disk' => 'public',
                ]);
            }

            $category->name = $request->name;

            $category->status = $request->status;
            if ($path) {
                $category->icon = $path;
            }
            $category->save();

            return redirect()->back()->with('success', 'Category Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // $category = Category::where('store_id', Auth::user()->seller->store->id)->find($id);
        $category = Category::findOrFail($id);
        // if (!$category) {
        //     return redirect()->back()->with('error', 'Cannot Delete This Category ');
        // }
        $this->authorize('delete', $category);
        // Check if the categories has products so don't delete a category that has products
        $result = $category->delete();
        // dd($result);
    }
}
