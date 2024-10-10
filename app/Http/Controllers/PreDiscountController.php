<?php

namespace App\Http\Controllers;

use App\Models\PreDiscount;
use Illuminate\Http\Request;

class PreDiscountController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->role->hasPermissionTo('view pre-discount')) {
            return abort(403, 'You do not have permission to access the view pre-discount.');
        }
        $preDiscounts = PreDiscount::where('user_id', auth()->id())->get();
        return view('pages.preDiscounts.index', compact('preDiscounts'));
    }
    public function store(Request $request)
    {
        if (!auth()->user()->role->hasPermissionTo('create pre-discount')) {
            return abort(403, 'You do not have permission to access the edit pre-discount.');
        }
        $request->validate([
            'title' => 'required',
            'amount' => 'required',
        ]);
        PreDiscount::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'amount' => $request->amount,
        ]);
        return back()->with('success', 'Discount added successFull');
    }
    public function edit(PreDiscount $preDiscount)
    {
        if (!auth()->user()->role->hasPermissionTo('edit pre-discount')) {
            return abort(403, 'You do not have permission to access the edit pre-discount.');
        }
        return view('pages.preDiscounts.edit', compact('preDiscount'));
    }
    public function update(Request $request, PreDiscount $preDiscount)
    {

        $request->validate([
            'title' => 'required',
            'amount' => 'required',
        ]);
        $preDiscount->update([
            'title' => $request->title,
            'amount' => $request->amount,
        ]);

        return back()->with('success', 'Discount updated successfully');
    }
    public function destroy(PreDiscount $preDiscount)
    {
        if (!auth()->user()->role->hasPermissionTo('delete pre-discount')) {
            return abort(403, 'You do not have permission to access the delete pre-discount.');
        }
        $preDiscount->delete();
        return back()->with('success', 'Discount Deleted Successfull');
    }
}
