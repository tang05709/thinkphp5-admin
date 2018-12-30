<?php
namespace app\backend\controller;

use think\Controller;
use think\Request;
use think\Session;
use app\common\model\Admins as AdminsModel;

class Auth extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginin(Request $request)
    {
       $name = $request->post('user_name');
       $password = $request->post('user_password');
       $captcha = $request->post('code');

       if(empty($name) && empty($password) && empty($captcha)) {
         $this->error('请填写完整'); 
       }
       if($captcha != Session::get('captcha')) {
        $this->error('验证码错误');
       }
       $user = AdminsModel::where('name', $name)->find();
       if(empty($name)) {
        $this->error('请填写完整'); 
       }
       if(!password_verify($password, $user->password)) {
        $this->error('请填写完整'); 
       }
       $user->last_login_time = time();
       $user->last_login_ip = $request->ip();
       $user->allowField(true)->save();
       Session::set('user_id', $user->id);
       Session::set('user_name', $name);
       $this->success('登陆成功', '/backend/index');
    }

    public function loginout() {
        Session::clear();
        $this->success('你已退出', '/backend/login');
    }
}
