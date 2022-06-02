<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // 1. 验证邮箱
        $request->validate(['email' => 'required|email']);
        $email = $request->email;
        // 2.获取对应用户
        $user = User::where('email',$email)->first();
        //如果不存在
        if(is_null($user)){
            session()->flash('danger', '邮箱未注册');
            return redirect()->back()->withInput();
        }
        //存在,生成token
        $token = hash_hmac('sha256', Str::random(40), config('app.key'));
        //入库,使用updateOrInsert保持Email唯一
        DB::table('password_resets')->updateOrInsert(['email' => $email],[
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => new Carbon,
        ]);
        //发送带token链接
        Mail::send('emails.reset_link', compact('token'), function($message) use($email){
            $message->to($email)->subject("忘记密码");
        });
        session()->flash('success', '重置邮件发送成功,请查收');
        return redirect()->back();
    }
}
