<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use DB;

class UserController extends Controller
{
    /**
     * 用户列表页
     */
    public function getIndex(Request $req){
        if($req->input('key')){
            $users = DB::table('user')->where(function($query) use ($req){
                $query->where('username', 'like', '%'.$req->input('key').'%');
            })->paginate(10);
        }else{
            $users = DB::table('user')->paginate(10);
        }
        foreach($users as &$v){
            if($v->status == 0){
                $v->status = '未激活';
            }else{
                $v->status = '已激活激活';
            }
            unset($v);
        }
        return view('admin.user.index', ['users'=> $users]);
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
       $time = time();
       $data['created_at'] = $time;
       $data['updated_at'] = $time;

       $res = DB::table('user')->insert($data);
       return $res ? view('admin.user.index')->with('info', '添加成功') : back()->with('info', '添加失败');
   }

    /**
     * 用户修改页面
     */
    public function getEdit(Request $req){
        $id = $req->input('id', '');
        $user = DB::table('user')->where('id', $id)->first();
        return view("/admin/user/edit", ['user'=>$user]);
    }

    /**
     * 修改操作
     */
    public function postUpdate(Request $req){
        $this->validate($req, [
            'id' => 'integer',
            'username' => 'required|max:30',
            'password' => 'required|max:30',
            'repassword' => 'required|max:30|same:password',
            'email' => 'required|email',
        ], [
            'id.integer' => 'id必须为整数',
            'username.required' => '用户名不能为空',
            'username.max' => '用户名长度不能超过30',
            'password.required' => '密码不能为空',
            'password.max' => '密码长度不能超过30',
            'repassword.required' => '确认密码不能为空',
            'repassword.same' => '两次密码不一致',
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
        ]);
        $data = $req->except('_token', 'repassword');
        $res = DB::table('user')->where('id',$data['id'])->update($data);
        if($res)
            return redirect('/admin/user/index')->with('msg', '修改成功');
        else
            return back()->with('msg', '修改失败');
    }
}
