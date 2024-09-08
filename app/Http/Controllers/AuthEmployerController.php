<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthEmployerController extends Controller
{
    public function loginEmp(){
        return view('auth.loginEmp');
    }

    public function handleLoginEmp(AuthRequest $request){
        //dd($request->only(['email','password']));
        $credentials=$request->only(['email','password']);
        if(Auth::guard('employer')->attempt($credentials)){
            return redirect('dashboard');
        }else{
            return redirect()->back()->with('error_msg','Paramétre de connexion non reconnu');
        }
    }
}
