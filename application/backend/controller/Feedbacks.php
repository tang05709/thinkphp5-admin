<?php

namespace app\backend\controller;

use app\backend\controller\Application;
use think\Request;
use app\common\model\Feedbacks as FeedbacksModel;

class Feedbacks extends Application
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $tid = $request->get('tid');
        $condition['tid'] = $tid;

        $search = $request->get('search');
        if (!empty($search)) {
            $condition['title'] = ['like', '%'.$search.'%'];
        }

        $list = FeedbacksModel::where($condition)->paginate(20, false, ['query' => $request->param()]);

        $data = [
            'list' => $list,
            'tid' => $tid
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
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
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
        $model = FeedbacksModel::get($id);
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
        $model = new FeedbacksModel();
        $result = $model->allowField(true)->save($data,['id' => $id]);
        if($result){
            $this->success('修改成功', '/backend/feedbacks?tid='.$request->post('tid'));
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
        $model = FeedbacksModel::get($id);
        $result = $model->delete();
        if($result){
          return json_encode('删除成功');
        } else {
          return json_encode('删除失败');
        }
    }
}
