<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->role->hasPermissionTo('view purchase')){
            return abort(403, 'You do not have permission to access the create supplier.');
        }
        $purchases=Purchase::filter()->latest()->paginate(20);
        return view('pages.purchase.list', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->role->hasPermissionTo('create purchase')){
            return abort(403, 'You do not have permission to access the create supplier.');
        }
        $purchase = new Purchase();
        return view('pages.purchase.create', compact('purchase'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Purchase $purchase)
    {
        if (!auth()->user()->role->hasPermissionTo('edit purchase')){
            return abort(403, 'You do not have permission to access the create supplier.');
        }

        return view('pages.purchase.edit', compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        if (!auth()->user()->role->hasPermissionTo('delete purchase')){
            return abort(403, 'You do not have permission to access the create supplier.');
        }
        $purchase->delete();
        return redirect()->back();
    }
    public function invoice(Purchase $purchase)
    {
        // dd($purchase->supplier);
        return view('pages.purchase.invoice', compact('purchase'));
    }
}
