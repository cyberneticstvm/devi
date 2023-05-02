<?php

namespace App\Http\Controllers;

use App\Models\UserBranch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Session;

class AuthController extends Controller
{
    public function login(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        $input = $request->all();
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = array($fieldType => $input['username'], 'password' => $input['password'], 'status' => 1);
        if(Auth::attempt($credentials)):
            $user = Auth::getProvider()->retrieveByCredentials($credentials);
            Auth::login($user, $request->get('remember'));
            return redirect()->route('dash')->with("success", "Logged in successfully!");
        endif;  
        return redirect("/")->with('error', 'Login details are not valid')->withInput($request->all());
    }

    public function dash(){
        $role = Role::where('name', Auth::user()->roles->pluck('name')->implode(''))->first();
        $userbranches = UserBranch::where('user_id', Auth::user()->id)->get();
        $dash = ($role->dashboard) ? $role->dashboard : 'dash.default' ;
        return view($dash, compact('userbranches'));
    }

    public function setuserbranch(Request $request){
        $this->validate($request, [
            'branch' => 'required',
        ]);
        Session::put('branch', $request->branch);
        return redirect()->route('dash')->with("success", "Branch updated successfully!");
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/')->with('success','User logged out successfully');
    }
}
