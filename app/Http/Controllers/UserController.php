<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Hash;
use DB;

class UserController extends Controller
{
    /**
     * 用户列表页
     */
    public function getIndex(Request $req){
        $key = $req->input('key', '');
        $status = $req->input('status', '');

        $users = DB::table('user')
            ->where(function($query) use ($key){
                if($key !== ''){
                    $query->where('username', 'like', '%'.$key.'%');
                }
            })->where(function($query) use ($status){
                if($status !== ''){
                    $query->where('status', '=', $status);
                }
            })
            ->paginate(10);

        foreach($users as &$v){
            if($v['status'] == 0){
                $v['status'] = '未激活';
            }else{
                $v['status'] = '已激活激活';
            }
            unset($v);
        }
        return view('admin.user.index', ['users'=> $users, 'key'=>$key, 'status'=>$status]);
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
   public function postInsert(UserRequest $req){
       //1. 表单验证
//       $this->validate($req, [
//           'username' => 'required|max:30',
//           'password' => 'required|max:30',
//           'repassword' => 'required|max:30|same:password',
//           'email' => 'required|email',
//       ], [
//           'username.required' => '用户名不能为空',
//           'username.max' => '用户名长度不能超过30',
//           'password.required' => '密码不能为空',
//           'password.max' => '密码长度不能超过30',
//           'repassword.required' => '确认密码不能为空',
//           'repassword.same' => '两次密码不一致',
//           'email.required' => '邮箱不能为空',
//           'email.email' => '邮箱格式不正确',
//       ]);
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
    public function postUpdate(UserRequest $req){
        $data = $req->except('_token', 'repassword');
        $res = DB::table('user')->where('id',$data['id'])->update($data);
        if($res)
            return redirect('/admin/user/index')->with('msg', '修改成功');
        else
            return back()->with('msg', '修改失败');
    }

    /**
     * 用户删除
     */
    public function getDel(Request $req){
        $uid = $req->input('id', 0);
        if($uid === 0){
            return response()->json(['status'=>false, 'msg'=>'参数错误']);
        }
        $res = DB::table('user')->where('id', '=', $uid)->delete();
        return $res ? response()->json(['status'=>true, 'msg'=>'删除成功']) : response()->json(['status'=>false, 'msg'=>'删除失败']);
    }

    /**
     * 用户批量审核
     */
    public function postBatchAudit(Request $req){
        $ids = $req->input('ids', []);
        $res = DB::table('user')->whereIn('id', $ids)->update(['status'=> '1']);
        return $res !== false ? response()->json(['status'=>true, 'msg'=>'已审核'.$res.'个用户']) : response()->json(['status'=>false, 'msg'=>'审核失败']);
    }
}
