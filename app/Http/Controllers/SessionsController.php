<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials)){
            //登录成功
            session()->flash('success','欢迎回来');
            return redirect()->route('users.show',['user' => Auth::user()]);
        }else{
            //登录失败
            session()->flash('danger', '账号或密码错误');
            return redirect()->back()->withInput();
        }
        return;
    }
}
