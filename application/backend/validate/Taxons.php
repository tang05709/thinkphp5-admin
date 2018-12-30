<?php
namespace app\backend\validate;

use think\Validate;

class Taxons extends Validate
{
    protected $rule = [
        'name'  =>  'require',
        'module' =>  'require',
    ];
    
    protected $message = [
        'name.require'  =>  '名称必须',
        'module.require' =>  '模块必须',
    ];
    
    /*protected $scene = [
        'add'   =>  ['name','email'],
        'edit'  =>  ['email'],
    ];*/
}
?>