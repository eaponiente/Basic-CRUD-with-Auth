<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if($request->method() === 'POST')
        {
            Auth::attempt([
                'username'	=> $request->username,
                'password'	=> $request->password
            ]);

            if( Auth::check() )
            {
                return redirect()->route('users.index');
            }

            return redirect()->route('user_login')->with('error', 'Wrong credentials');
        }

        if( Auth::check() )
        {
            return redirect()->route('users.index');
        }

        $registration = request()->has('type');

        return view('frontend.login.index', compact('registration'));
    }

    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'username' => 'required|min:5|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20|confirmed'
        ]);

        if( $validator->fails() )
        {
            return redirect()->to('login' . '?type=registration')->withInput(request()->all())->withErrors($validator);
        }

        request()->merge([
            'password' => bcrypt(\request()->input('password')),
            'role' => 2
        ]);

        $user = User::create(request()->except(['password_confirmation']));

        Auth::loginUsingId($user->id);

        if( Auth::check() )
        {
            return redirect()->route('users.index');
        }
        
        abort(401, 'Unauthorized');

    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('user_login');
    }
}
