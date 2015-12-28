<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $r = Role::all();
        $roles=[];
        foreach($r as $role){
            $roles[$role->id] = $role->name;
        }
        return view('user.create')->with(compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
        'name'=> 'required',
        'first'=> 'required',
        'last'=> 'required',
        'email'=> 'required|email|unique:users',
        'type'=> 'required|exists:roles,id',
    ];
        $this->validate($request, $rules);
        $data['email'] = $request->email;
        $data['password'] = str_random(8);

//        \Mail::queue('emails.sendpassword', $data, function($message) use ($request) {
//            $message->subject( 'Profile password.');
//            $message->to($request->email);
//        });
        $userData = $request->all();
        $userData['password'] = bcrypt($data['password']);
        $userData['paid'] = 1;
        $userData['activation'] = 1;
        User::create($userData);
        return redirect('admin/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $role = Role::find($user->type);
        return view('user.show',compact('user', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $role = Role::find($user->type);
        $roles = Role::all();
        return view('user.edit',compact('user', 'role', 'roles'));
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
        $user = User::find($id);
        $rules = [
            'name'=> 'required',
            'type'=> 'required|exists:roles,id',
        ];
        if($user->email != $request->email){
            $rules['email'] = 'required|email|unique:users';
        }

        $this->validate($request, $rules);

        $user->update($request->all());
        return redirect('admin/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('admin/user');
    }


    public function suspend($id)
    {
        $user = User::find($id);
        $user->archive = 1;
        $user->activation = 0;
        $user->save();
        return redirect('admin/user');
    }

    public function unsuspend($id)
    {
        $user = User::find($id);
        $user->archive = 0;
        $user->activation = 1;
        $user->save();
        return redirect('admin/user');
    }

    public function upgrade($id)
    {
        $user = User::find($id);
        $user->type = 2;
        $user->save();
        return redirect('admin/user');
    }

    public function downgrade($id)
    {
        $user = User::find($id);
        $user->type = 1;
        $user->save();
        return redirect('admin/user');
    }




}
