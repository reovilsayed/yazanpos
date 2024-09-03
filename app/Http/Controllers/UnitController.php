<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::latest()->filter()->paginate(30);
        return view('pages.units.list', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $unit = new Unit();
        return view('pages.units.create', compact('unit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'quantity' => 'required|integer',
        ]);
        

        $unit = new Unit;
        $unit->name = $request->name;
        $unit->quantity = $request->quantity;
        $unit->save();
        
        return redirect()->route('units.index')->with('success', 'Unit Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return view('pages.units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {

        $request->validate([
            'name' => 'required|string|max:20',
            'quantity' => 'required|integer',
        ]);

        $unit->name = $request->name;
        $unit->quantity = $request->quantity;
        $unit->save();
        return redirect()->back()->with('success', 'Unit updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->back()->with('success', 'Unit deleted');
    }
}
