<?php

namespace app\backend\controller;

use app\backend\controller\Application;
use think\Request;
use app\common\model\FriendLinks as FriendLinksModel;

class FriendLinks extends Application
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $list = FriendLinksModel::all();
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
        $validate = $this->validate($data, 'FriendLinks');
        if(true !== $validate){
            return $validate->getError();
        }
        $model = new FriendLinksModel($data);
        $result = $model->allowField(true)->save();
        if($result){
            $this->success('新增成功', '/backend/friend_links');
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
        $model = FriendLinksModel::get($id);
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
        $validate = $this->validate($data, 'FriendLinks');
        if(true !== $validate){
            return $validate->getError();
        }
        $model = new FriendLinksModel();
        $result = $model->allowField(true)->save($data,['id' => $id]);
        if($result){
            $this->success('修改成功', '/backend/friend_links');
        } else {
            $this->error('修改失败');
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
        $model = FriendLinksModel::get($id);
        @unlink($_SERVER['DOCUMENT_ROOT'] . $model->logo);
        $result = $model->delete();
        if($result){
          return json_encode('删除成功');
        } else {
          return json_encode('删除失败');
        }
    }
}
