<?php
namespace App\Http\Controllers\Admin;
use App\Http\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades;
require (app_path().'/org/code/Code.class.php');
class LoginController extends CommonController{
	public function login(){
		if($input=Facades\Input::all()){
            $code=new \Code;
            $getcode=$code->get();
            if(strtoupper($input['code'])!=$getcode){
                 return back()->with('msg','验证码错误');
            }
            $user=User::first();
            if($user->user_name!=$input['user_name']||$user->user_pass!=$input['user_pass']){
                return back()->with('msg','用户名或密码错误!');
            }
             session(['user'=>$user]);
             return redirect('admin/index');

		}else{
		    return view('admin.login');
		}
	}
	public function code(){
		$code=new \Code;
		$code->make();
	}
	public function quit()
    {
        session(['user'=>null]);
        return redirect('admin/login');
      }


}
