<?php
namespace app\backend\validate;

use think\Validate;

class Configs extends Validate
{
    protected $rule = [
        'title'  =>  'require',
        'name' =>  'require',
    ];
    
    protected $message = [
        'title.require'  =>  '名称必须',
        'name.require' =>  '标识必须',
    ];
    
    /*protected $scene = [
        'add'   =>  ['name','email'],
        'edit'  =>  ['email'],
    ];*/
}
?>