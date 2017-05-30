<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use DB;

class UserController extends Controller
{
    public function getIndex(){
        return view('admin.user.index');
    }
    /**
     * 添加用户页面
     */
    public function getAdd(){
        return view('admin.user.add');
    }

    /**
     * 添加用户
     */
   public function postInsert(Request $req){
       //1. 表单验证
       $this->validate($req, [
           'username' => 'required|max:30',
           'password' => 'required|max:30',
           'repassword' => 'required|max:30|same:password',
           'email' => 'required|email',
       ], [
           'username.required' => '用户名不能为空',
           'username.max' => '用户名长度不能超过30',
           'password.required' => '密码不能为空',
           'password.max' => '密码长度不能超过30',
           'repassword.required' => '确认密码不能为空',
           'repassword.same' => '两次密码不一致',
           'email.required' => '邮箱不能为空',
           'email.email' => '邮箱格式不正确',
       ]);
       //2. 添加数据
       $data = $req->except('_token', 'repassword');
       $data['password'] = Hash::make($data['password']);
       $data['token'] = str_random(32);

       $res = DB::table('user')->insert($data);
       return $res ? view('admin.user.index')->with('info', '添加成功') : back()->with('info', '添加失败');
   }
}
