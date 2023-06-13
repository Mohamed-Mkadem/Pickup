<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SectorController extends Controller
{
    public function index()
    {
        $sectors = Sector::paginate();

        return view('Admin.Sectors.sectors-index', ['sectors' => $sectors]);
    }
    public function filter(Request $request)
    {
        $search = $request->search ?? '';
        $minDate = $request->min_date ?? '';
        $maxDate = $request->max_date ?? '';
        $status = $request->status ?? ['active', 'inactive'];
        $sort = $request->sort ?? 'newest';
        $query = Sector::query();

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
        $sectors = $query->paginate();
        return view('Admin.Sectors.sectors-index', ['sectors' => $sectors]);
    }
    public function store(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'name' => ['required', 'string', 'unique:sectors'],
            'icon' => ['required', 'file', 'image', 'mimes:jpg,jpeg', 'max:1024000'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        } else {

            $file = $request->file('icon');
            $path = $file->store('/sectors', [
                'disk' => 'public',
            ]);

            Sector::create([
                'name' => $request->name,
                'icon' => $path,
                'status' => $request->status,
            ]);

            return redirect()->back()->with('success', 'Sector Added Successfully');
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => ['required', 'string', Rule::unique('sectors', 'name')->ignore($id)],
            'icon' => ['file', 'image', 'mimes:jpg,jpeg', 'max:1024000'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->withErrors($validatedData)->withInput();
        } else {
            $path = null;
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $path = $file->store('/sectors', [
                    'disk' => 'public',
                ]);
            }
            $sector = Sector::find($id);
            $sector->update([

                'name' => $request->name,
                'icon' => $path ? $path : $sector->icon,
                'status' => $request->status,

            ]);

            return redirect()->back()->with('success', 'Sector Updated Successfully');
        }
    }
    public function destroy($id)
    {
        $result = Sector::destroy($id);
        if ($result) {
            return redirect()->route('admin.sectors.index')->with('success', 'Sector Deleted Successfully');

        } else {
            return redirect()->route('admin.sectors.index')->with('error', 'Sector Cannot be Deleted ');
        }
    }
}
