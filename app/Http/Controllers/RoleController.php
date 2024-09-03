<?php

namespace App\Http\Controllers;

// use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->role->hasPermissionTo('view role')){
            return abort(403, 'You do not have permission to access the view role.');
        }
        $roles = Role::all();
        return view('pages.roles.index', compact('roles'));
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
        if (!auth()->user()->role->hasPermissionTo('create role')){
            return abort(403, 'You do not have permission to access the edit role.');
        }
        $request->validate([
            'name' => 'required',
        ]);
        Role::create([
            'name' => $request->name,
            'dsiplay_name' => $request->display_name,
        ]);
        return back()->with('success', 'Role added successFull');
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
    public function edit(Role $role)
    {
        if (!auth()->user()->role->hasPermissionTo('edit role')){
            return abort(403, 'You do not have permission to access the edit role.');
        }
        $dbPermissions = DB::table('permissions')->get();
        $permissions = $dbPermissions->groupBy('group');
        return view('pages.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {

         $request->validate([
            'name'=>'required',
            'display_name'=>'required',
         ]);
         $role->update([
            'name'=>$request->name,
            'dsiplay_name'=>$request->display_name,
         ]);
        $role->syncPermissions($request->permissions);

        return back()->with('success', 'Role added successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (!auth()->user()->role->hasPermissionTo('delete role')){
            return abort(403, 'You do not have permission to access the delete role.');
        }
        $role->delete();
        return back()->with('success', 'Role Deleted Successfull');
    }
}
