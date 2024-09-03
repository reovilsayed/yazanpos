<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class POSController extends Controller
{
    public function index()
    {
        return view('pages.pos');
    }
    public function customerStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
        ]);
        $customer = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ]);
        return redirect()->route('pos', ['customer' => $customer->id])->with('success', 'Customer create successfully');
    }
}
