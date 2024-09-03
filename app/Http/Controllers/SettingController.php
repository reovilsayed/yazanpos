<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->has('logo')) {
            $logo = $request->logo->store('setting', 'public');

            if (auth()->user()->setting) {
                if (auth()->user()->setting->logo && Storage::exists(auth()->user()->setting->logo)) {

                    Storage::delete(auth()->user()->setting->logo);
                }
            }
        } else {
            $logo = auth()->user()->setting ? auth()->user()->setting->logo : null;
        }
        $request->validate([
            'phone' => 'required|string',
            'tax' => 'nullable|numeric',
            'email' => 'nullable|email',
        ]);
        $settings = Setting::firstOrNew();
        Setting::updateOrCreate(
            [
                'id' => $settings->id,

            ],
            [
                'shopName' => $request->shopName,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'currency' => $request->currency,
                'tax' => $request->tax,
                'logo' => $logo,
                'manageStock' => $request->manageStock,
            ]
        );

        return back()->with('success', 'Setting added successFull');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8', 'confirmed',
        ]);

        $user = auth()->user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully');
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
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
