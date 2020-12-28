<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{
    public function permissions(){
        $user = User::find(3);


//
//        Permission::create([
//            'name'=>'users'
//        ]);
//
//        Permission::create([
//            'name'=>'admin'
//        ]);
//        Role::create(['name'=>'employee']);
//        Role::create(['name'=>'editor']);
//        $role = Role::findByName('editor');
//        $role->givePermissionTo('users');

        $user->givePermissionTo('admin');
//        $roles = $user->getRoleNames();
//        dd($user->roles());
        return 1;


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return  view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($d)
    {
        $roles = Role::all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'status'=>'required',



        ]);
        if($request->id){
            $user = User::where('id',$request->id)->update(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'status' => $request->status,
                ]);

        }else{
            $user = User::Create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'status' => $request->status,
                ]);
        }


        if($request->roles){
            $roles = [];
            foreach ($request->roles as $role){
                $roleName = Role::findByid($role);

                array_push($roles,$roleName);
            }
            $user = User::latest()->first();
            $user->syncRoles($roles);
        }
        if($user->wasChanged()){
            session()->flash('update', 'user has been updated successfully');
        }elseif($user->wasRecentlyCreated) {
            session()->flash('create','user created successfully');
        }

         return redirect(app()->getLocale().'/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($d,User $user)
    {
        $roles = Role::all();
        return view('users.create',compact('roles','user'));
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
    public function destroy($d,User $user)
    {
        $user->delete();
        session()->flash('delete','user has been deleted successfully');
        return redirect(app()->getLocale().'users');
    }
}
