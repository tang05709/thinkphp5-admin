<?php
namespace app\backend\validate;

use think\Validate;

class Articles extends Validate
{
    protected $rule = [
        'tid'  =>  'require',
        'title' =>  'require',
    ];
    
    protected $message = [
        'tid.require'  =>  '栏目必须',
        'title.require' =>  '标题必须',
    ];
    
    /*protected $scene = [
        'add'   =>  ['name','email'],
        'edit'  =>  ['email'],
    ];*/
}
?>