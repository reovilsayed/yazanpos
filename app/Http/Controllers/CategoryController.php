<?php

namespace App\Http\Controllers;

use App\Models\Category;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (!auth()->user()->role->hasPermissionTo('view category')){
            return abort(403, 'You do not have permission to access the view Category.');
        }
        $categories = Category::filter()->latest()->paginate(30);
        return view('pages.categories.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->role->hasPermissionTo('create category')){
            return abort(403, 'You do not have permission to access the create category.');
        }
        return view('pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->role->hasPermissionTo('create category')){
            return abort(403, 'You do not have permission to access the create category.');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('public/category');
        }

        Category::create($data);

        return back()->with('message', 'Category Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        if (!auth()->user()->role->hasPermissionTo('edit category')){
            return abort(403, 'You do not have permission to access the create category.');
        }
        return view('pages.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if (!auth()->user()->role->hasPermissionTo('edit category')){
            return abort(403, 'You do not have permission to access the create category.');
        }

        if ($request->has('image')) {
            $image = $request->file('image')->store('public/category');
            Storage::delete($request->image);
        } else {
            $image = $category->image;
        }
        $category->update([
            'name' => $request->name,
            'image' => $image,
        ]);
        return redirect('/categories')->with('message', 'Category Edit SuccessFull');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if (!auth()->user()->role->hasPermissionTo('delete category')){
            return abort(403, 'You do not have permission to access the create category.');
        }
        Storage::delete($category->image);
        $category->delete();
        return redirect('/categories')->with('message', 'Category Delete successFull !');
    }
}
