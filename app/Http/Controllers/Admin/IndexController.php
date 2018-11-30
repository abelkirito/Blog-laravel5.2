<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Model\User;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
class IndexController extends CommonController
{
   public function index(){
       return view('admin.index');
   }
   public function info(){
       return view('admin.info');
   }
   public function pass(){
       if($input=Facades\Input::all()){
           $rules=[
               'password'=>'required|between:6,20|confirmed',
           ];
           $message=[
               'password.required'=>'请输入新密码!',
               'password.between'=>'新密码必须在6到20位之间!',
               'password.confirmed'=>'确认密码不一致!',
           ];
           $validator=Facades\Validator::make($input,$rules,$message);
           if($validator->passes()){
              $name=session('user');
              $name=$name['user_name'];//管理员姓名
               $user=User::all()->where('user_name',$name);
               $pwd=$user[0]['user_pass'];
               $pwd=Facades\Crypt::decrypt($pwd);
               if($pwd==$input['password_o']){
                   if($input['password_o']==$input['password']){
                       return back()->with('error','旧密码与新密码不能相同！');
                   }else{
                       $npwd=Facades\Crypt::encrypt($input['password']);
                       $result=User::where('user_name',$name)
                                     ->update(['user_pass'=>$npwd]);
                       if($result) {
                           return back()->with('error', '修改成功!');
                       }else {
                           return back()->with('error', '修改失败!');
                       }

                   }
               }else{
                   return back()->with('error','原始密码错误！');
               }
           }else{
               return redirect('admin/pass')->withErrors($validator);
           }
       }else{
      return view('admin.pass');
       }
   }
}
