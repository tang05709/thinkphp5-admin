<?php

namespace app\backend\controller;

use app\backend\controller\Application;
use think\Request;
use app\common\model\Taxons as TaxonsModel;

class Pages extends Application
{
  public function index(Request $request) 
  {
    $tid = $request->get('tid');
    $model = TaxonsModel::find($tid);
    $data = [
      'model' => $model
    ];
    return view('index', $data);
  }

  public function update(Request $request, $id) 
  {
    $content = $request->post('content');
    $model = TaxonsModel::find($id);
    $model->content = $content;
    $result = $model->allowField(true)->save();
    if($result){
      $this->success('修改成功', '/backend/pages?tid='.$id);
    } else {
      $this->error('修改失败');
    }
  }
}

?>