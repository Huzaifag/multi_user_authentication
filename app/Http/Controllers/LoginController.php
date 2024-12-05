<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    # This shows log in page to general users
    public function index(){
        return view('login');
    }

    # This will authenticate users
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->passes()){
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                return redirect()
                ->route('account.dashboard');
            }else{
                return redirect()
                ->route('account.login')
                ->with('error','Either email or password field is invalid');
            }
        }else{
            return redirect()
            ->route('account.login')
            ->withInput()
            ->withErrors($validator);
        }
    }

    # This will shows register page to users
    public function register(){
        return view('register');
    }

    # This will register a user
    public function processRegister(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        if($validator->passes()){
            $user = new User();
            $user->name= $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = 'customer';
            $user->save();
            return redirect()
            ->route('account.login')->with('success', 'You have registered successfully');

        }else{
            return redirect()
            ->route('account.register')
            ->withInput()
            ->withErrors($validator);
        }
    }

    # This will logout user

    public function logout(){
        Auth::logout();
        return redirect()
            ->route('account.login');
    }

}
