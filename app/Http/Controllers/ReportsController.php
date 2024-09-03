<?php

namespace App\Http\Controllers;

use App\Mail\CustomerReport;
use App\Models\User;
use App\Report\Earnings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.report.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function send_report(User $customer)
    {
        if ($customer->email) {
            Mail::to($customer->email)->send(new CustomerReport($customer));
            return back()->with('success', 'Email sent successfully');
        }
        return back();
    }
}
