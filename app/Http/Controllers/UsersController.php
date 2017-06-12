<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('username')->get();
        
        return view('frontend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-user');

        return view('frontend.users.crud');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-user');

        $this->validate($request, [
            'username' => 'required|min:5|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20|confirmed'
        ]);

        request()->merge([
            'password' => bcrypt(request()->input('password'))
        ]);

        User::create(request()->except(['password_confirmation']));

        return redirect()->route('users.index')->with('success', 'User successfully created');
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
    public function edit($id)
    {
        $this->authorize('edit-user');

        $edit = User::find($id);

        return view('frontend.users.crud', compact('edit'));
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
        $this->authorize('edit-user');

        $edit = User::find($id);

        $this->validate($request, [
            'username' => [
                'required', 'min:5', Rule::unique('users')->ignore($edit->id),
            ],
            'email' => [
                'required', 'email', Rule::unique('users')->ignore($edit->id)
            ],
            'password' => 'nullable|min:6|max:20|confirmed'
        ]);

        request()->merge([
            'password' => $request->has('password') ? bcrypt(request()->input('password')) : $edit->password
        ]);

        $edit->update(request()->except(['password_confirmation']));

        return redirect()->route('users.index')->with('success', 'User successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-user');

        $edit = User::find($id);

        if( $edit )
        {
            $edit->delete();

            return redirect()->route('users.index')->with('success', 'User '.$edit->username.' successfully updated');
        }

        abort(404, 'Page not found');
    }
}
