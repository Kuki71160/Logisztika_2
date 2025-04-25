<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json(['success' => true, 'suppliers' => $suppliers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:255|min:9'
        ]);

        $supplier = Supplier::create([
            'name' => $request->name,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone
        ]);

        return response()->json(['success' => true, 'supplier' => $supplier]);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:255|min:9'
        ]);

        $supplier->name = $request->name;
        $supplier->contact_phone = $request->contact_phone;
        $supplier->contact_email = $request->contact_email;
        $supplier->save();

        return response()->json(['success' => true, 'supplier' => $supplier]);
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return response()->json(['success' => true, 'message' => 'Supplier deleted successfully']);
    }
}
