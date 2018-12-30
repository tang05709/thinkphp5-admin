<?php

namespace app\backend\controller;

use app\backend\controller\Application;
use think\Request;
use app\common\model\Admins as AdminsModel;

class Admins extends Application
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = AdminsModel::all();
        $data = [
            'list' => $list
        ];
        return view('index', $data);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->post();
        $validate = $this->validate($data, 'Admins');
        if(true !== $validate){
            return $validate->getError();
        }
        $model = new AdminsModel();
        $model->name = $request->post('name');
        $model->password = $request->post('password');
        $result = $model->allowField(true)->save();
        if($result){
            $this->success('新增成功', '/backend/admins');
        } else {
            $this->error('新增失败');
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        $model = AdminsModel::get($id);
        $data = [
            'model' => $model
        ];
        return view('edit', $data);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->post();
        $validate = $this->validate($data, 'Admins');
        if(true !== $validate){
            return $validate->getError();
        }
        $model = AdminsModel::get($id);
        $oldpassword = $request->post('oldpassword');
        if(password_verify($oldpassword, $model->password)) {
          $model->password = $request->post('password');
          $result = $model->allowField(true)->save();
          if($result){
            $this->success('修改成功', '/backend/admins');
          } else {
            $this->error('修改失败');
          }
        } else {
          $this->error('旧密码错误');
        }

    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        $model = AdminsModel::get($id);
        $result = $model->delete();
        if($result){
          return json_encode('删除成功');
        } else {
          return json_encode('删除失败');
        }
    }
}
