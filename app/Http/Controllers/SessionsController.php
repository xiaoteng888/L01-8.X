<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    public function __construct()
    {
        //只能未登录访问的方法
        $this->middleware('guest', [
            'only' => ['create'],
        ]);
        // 限流 10 分钟十次
        $this->middleware('throttle:10,10',[
            'only' => ['store'],
        ]);
    }

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

        if(Auth::attempt($credentials, $request->has('remember'))){
            //登录成功
            if(Auth::user()->activated){
                session()->flash('success','欢迎回来');
                $fallback = route('users.show',['user' => Auth::user()]);
                return redirect()->intended($fallback);
            }else{
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }

        }else{
            //登录失败
            session()->flash('danger', '账号或密码错误');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Request $requets)
    {
        Auth::logout();
        session()->flash('success', '您已经成功退出');
        return redirect('login');
    }
}
