<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $permissions = Permission::all();
       return  view('roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $role = Role::updateOrCreate(
           [
               'id'=>$request->id
           ],
           [
               'name'=>$request->name,
           ]
       );
      if($request->permissions){
          foreach ($request->permissions as $permission){
              $roleName = Role::findByName($request->name);
              $permissionId = Permission::findById($permission);
              $roleName->syncPermissions($permissionId);
          }
      }
        if($role->wasChanged()){
            session()->flash('update', 'role has been updated successfully');
        }elseif($role->wasRecentlyCreated) {
            session()->flash('create', 'role has been added successfully');
        }
        return redirect('roles');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role  $role)
    {
        $permissions  = $role->getAllPermissions();
//        dd($permissions);
        return view('roles.show',compact('role','permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role  $role)
    {
        $permissions = Permission::all();
        return view('roles.create',compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role  $role)
    {
        $role->delete();
        session()->flash('delete','Role has been deleted successfully');
        return  redirect('roles');
    }
}
