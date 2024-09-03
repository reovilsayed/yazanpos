<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!auth()->user()->role->hasPermissionTo('view supplier')){
            return abort(403, 'You do not have permission to access the supplier view.');
        }
        $suppliers = Supplier::latest()->when($request->search_supplier, function ($query, $search) {
            return $query->search($search);
        })->paginate(30)->withQueryString();
       return view('pages.suppliers.list',compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->role->hasPermissionTo('create supplier')){
            return abort(403, 'You do not have permission to access the customer edit.');
        }
        return view('pages.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (!auth()->user()->role->hasPermissionTo('create supplier')){
            return abort(403, 'You do not have permission to access the create supplier.');
        }
        // dd(json_encode($request->contact_person));
        $request->validate([
            'name' => 'required|string|max:150',
            'logo' => 'nullable|file|max:2048', // adjust as needed
            'registration_number' => 'nullable|string|max:255',
            'vat_number' => 'nullable|string|max:255',
            'industry_type' => 'nullable|string|max:255',
            // 'contact_person' => 'required|string|max:255',
            'contact_person_designation' => 'nullable|string|max:255',
            'contact_person_email' => 'nullable|email|max:255',
            'contact_person_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
        ]);
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public'); 
        }

        // Create a new supplier instance
        $supplier = new Supplier([
            'name' => $request->input('name'),
            'logo' => $logoPath,
            'registration_number' => $request->input('registration_number'),
            'vat_number' => $request->input('vat_number'),
            'industry_type' => $request->input('industry_type'),
            'contact_person' => json_encode($request->input('contact_person')),
            'contact_person_designation' => $request->input('contact_person_designation'),
            'contact_person_email' => $request->input('contact_person_email'),
            'contact_person_phone' => $request->input('contact_person_phone'),
            'company_email' => $request->input('company_email'),
            'company_phone' => $request->input('company_phone'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'website' => $request->input('website'),
        ]);

        // Save the supplier to the database
        $supplier->save();

        // Redirect or respond as needed
        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        if (!auth()->user()->role->hasPermissionTo('edit supplier')){
            return abort(403, 'You do not have permission to access the create supplier.');
        }
        return view('pages.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        if (!auth()->user()->role->hasPermissionTo('edit supplier')){
            return abort(403, 'You do not have permission to access the create supplier.');
        }
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:150',
            'logo' => 'nullable|file|max:2048', // adjust as needed
            'registration_number' => 'nullable|string|max:255',
            'vat_number' => 'nullable|string|max:255',
            'industry_type' => 'nullable|string|max:255',
            // 'contact_person' => 'required|string|max:255',
            'contact_person_designation' => 'nullable|string|max:255',
            'contact_person_email' => 'nullable|email|max:255',
            'contact_person_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
        ]);
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public'); 
        }
        $supplier = $supplier->update([
            'name' => $request->input('name'),
            'logo' => $logoPath,
            'registration_number' => $request->input('registration_number'),
            'vat_number' => $request->input('vat_number'),
            'industry_type' => $request->input('industry_type'),
            'contact_person' => json_encode($request->input('contact_person')),
            'contact_person_designation' => $request->input('contact_person_designation'),
            'contact_person_email' => $request->input('contact_person_email'),
            'contact_person_phone' => $request->input('contact_person_phone'),
            'company_email' => $request->input('company_email'),
            'company_phone' => $request->input('company_phone'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'website' => $request->input('website'),
        ]);
        return back()->with('success', 'Supplier created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        if (!auth()->user()->role->hasPermissionTo('delete supplier')){
            return abort(403, 'You do not have permission to access the create supplier.');
        }
        if ($supplier->image && Storage::exists($supplier->image)) {
            Storage::delete($supplier->image);
        }
        
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Product deleted');
    }
}
