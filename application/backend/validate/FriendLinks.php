<?php
namespace app\backend\validate;

use think\Validate;

class FriendLinks extends Validate
{
    protected $rule = [
        'name'  =>  'require',
        'url' =>  'require',
    ];
    
    protected $message = [
        'name.require'  =>  '名称必须',
        'email.require' =>  '链接必须',
    ];
    
    /*protected $scene = [
        'add'   =>  ['name','email'],
        'edit'  =>  ['email'],
    ];*/
}
?>