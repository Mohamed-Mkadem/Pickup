<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::paginate();

        return view('Admin.fees', ['fees' => $fees]);
    }

    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => ['required', 'string', 'unique:fees', 'max:50'],
            'method' => ['required', 'string', 'max:50'],
            'features' => ['required', 'string', 'max:600'],
            'value' => ['required', 'numeric', 'min:1'],
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        } else {
            Fee::create([
                'name' => $request->name,
                'value' => $request->value,
                'features' => $request->features,
                'method' => $request->method,
            ]);
            return redirect()->back()->with('success', 'Fee Added Successfully');
        }

    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'method' => ['required', 'string', 'max:50'],
            'features' => ['required', 'string', 'max:600'],
            'value' => ['required', 'numeric', 'min:1'],
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();

        } else {
            $fee = Fee::find($id);
            if (!$fee) {
                return redirect()->back()->with('error', 'Fee Not Found');
            }
            $fee->update([
                'value' => $request->value,
                'features' => $request->features,
                'method' => $request->method,
            ]);
            return redirect()->back()->with('success', 'Fee Updated Successfully');
        }
    }
}
