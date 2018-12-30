<?php
namespace app\backend\validate;

use think\Validate;

class Admins extends Validate
{
    protected $rule = [
        'name'  =>  'require',
        'password' =>  'require',
    ];
    
    protected $message = [
        'name.require'  =>  '名称必须',
        'password.require' =>  '密码必须',
    ];
    
    /*protected $scene = [
        'add'   =>  ['name','email'],
        'edit'  =>  ['email'],
    ];*/
}
?>