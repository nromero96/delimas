<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $name = $request->get('filterbyname');
        $email = $request->get('filterbyemail');


        $users = User::where('users.name','LIKE', "%$name%")
                                ->where('users.email','LIKE', "%$email%")
                                ->orderBy('users.name', 'ASC')
                                ->paginate(20);

        return view('user.index')->with('users',$users);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $users = new User();
        $users->name = $request->get('name');
        $users->email = $request->get('email');
        $users->role = $request->get('role');
        $users->password = bcrypt($request->input('password'));
        $users->status = $request->get('status');
        $users->save();
        return redirect('/users');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit')->with('user',$user);
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
    public function destroy($id)
    {
        //
    }
}
