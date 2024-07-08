<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $permissions = Permission::orderBy('created_at', 'DESC')->paginate(10);
        return view('permissions.list', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator =  Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name',
        ]);

        if ($validator->passes()) {
            Permission::create([
                'name' => $request->name,
            ]);
            return redirect()->route('permissions.index')->with('success', 'Permission added successfully.');
        } else {
            return redirect()->route('permissions.create')->withErrors($validator)->withInput()->withErrors($validator);
        }
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
        $permission = Permission::findOrFail($id);
        return view('permissions.edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::findOrFail($id);
        $validator =  Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,' . $id . ',id'
        ]);

        if ($validator->passes()) {
            // Permission::create([
            //     'name' => $request->name,
            // ]);
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
        } else {
            return redirect()->route('permissions.create')->withErrors($validator)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $permission = Permission::find($id);
        if ($permission == null) {
            session()->flash('error', 'Permission not found');
            return response()->json([
                'status' => 'false',
            ]);
        }
        $permission->delete();
        session()->flash('success', 'Permission deleted successfully');
        return response()->json([
            'status' => 'true',
        ]);
    }
}
