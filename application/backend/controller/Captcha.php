<?php
namespace app\backend\controller;

use think\Controller;
use think\Request;
use think\Session;
use captcha\Captcha as CaptchaClass;

class Captcha extends Controller
{
  public function get_captcha() {
    $captcha = new CaptchaClass();
    $code = $captcha->rand_code();
    Session::set('captcha', $code);
    $captcha->create_captcha($code);
  }
}

?>