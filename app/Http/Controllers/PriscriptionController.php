<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Priscription;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Stmt\TraitUseAdaptation\Precedence;

class PriscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $priscriptions = Priscription::filter()->latest()->paginate(24);
        return view('pages.priscription.list', compact('priscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $priscription = new Priscription();
        return view('pages.priscription.create', compact('priscription'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'nullable|string',
            'symptoms' => 'required',
            'age' => 'nullable|numeric',
            'gender' => 'nullable',
            'customer_id' => 'required|exists:users,id',
            'product.*' => 'required',
            'product.*.id' => 'required',
            'product.*.scheduled' => 'required',
            'product.*.dose' => 'nullable'

        ]);
        $priscription = Priscription::create([
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'customer_id' => $request->customer_id,
            'symptoms' => $request->symptoms,
        ]);

        foreach ($request->product as $product) {
            $priscription->products()->attach($product['id'], ['dose' => $product['dose'] ?? '', 'scheduled' => $product['scheduled']]);
        }

        return redirect('/priscription')->with('success', 'Priscription Added SuccessFull');
    }

    /**
     * Display the specified resource.
     */
    public function show(Priscription $priscription)
    {
        // $priscription=Priscription::latest()->get();
        return view('pages.priscription.invoice', compact('priscription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Priscription $priscription)
    {
        return view('pages.priscription.edit', compact('priscription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Priscription $priscription)
    {

        $request->validate([
            'name' => 'nullable|string',
            'symptoms' => 'required',
            'age' => 'nullable|numeric',
            'gender' => 'nullable',
            'customer_id' => 'required|exists:users,id',
            'product.*' => 'required',
            'product.*.id' => 'required',
            'product.*.scheduled' => 'required',
            'product.*.dose' => 'required'

        ]);

        $priscription->update([
            'name' => $request->name,
            'age' => $request->age,
            'gender' => $request->gender,
            'customer_id' => $request->customer_id,
            'symptoms' => $request->symptoms,
        ]);

        $data = [];
        if ($request->product && count($request->product)) {
            foreach ($request->product as $product) {
                $data[$product['id']] = ['dose' => $product['dose'], 'scheduled' => $product['scheduled']];
            }
        }


        $priscription->products()->sync($data);
        return redirect('/priscription')->with('success', 'Priscription Added SuccessFull');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Priscription $priscription)
    {
        $priscription->delete();
        return redirect('/priscription')->with('success', 'priscription Delete successFull !');
    }
}
