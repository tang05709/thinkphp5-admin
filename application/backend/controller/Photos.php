<?php

namespace app\backend\controller;

use app\backend\controller\Application;
use think\Request;
use taxon\TaxonTree;
use app\common\model\Photos as PhotosModel;

class Photos extends Application
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $tid = $request->get('tid');
        $taxons = $this->get_taxons();
        $tree = new TaxonTree($taxons);
        $taxon_ids = $tree->get_id_children($tid);
        $condition['tid'] = ['in', $taxon_ids];

        $search = $request->get('search');
        if (!empty($search)) {
            $condition['title'] = ['like', '%'.$search.'%'];
        }

        $list = PhotosModel::where($condition)->paginate(20, false, ['query' => $request->param()]);
        $children = [];
        if( count($taxon_ids) > 0 ) {
            $children = $tree->get_option_children($tid);
        }

        $data = [
            'list' => $list,
            'tid' => $tid,
            'children' => $children
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
        $validate = $this->validate($data, 'Photos');
        if(true !== $validate){
            return $validate->getError();
        }
        $model = new PhotosModel($data);
        $result = $model->allowField(true)->save();
        if($result){
            $this->success('新增成功', '/backend/photos?tid='.$request->post('tid'));
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
        $model = PhotosModel::get($id);
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
        $validate = $this->validate($data, 'Photos');
        if(true !== $validate){
            return $validate->getError();
        }
        $model = new PhotosModel();
        $result = $model->allowField(true)->save($data,['id' => $id]);
        if($result){
            $this->success('修改成功', '/backend/photos?tid='.$request->post('tid'));
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
        $model = PhotosModel::get($id);
        @unlink($_SERVER['DOCUMENT_ROOT'] . $model->image);
        foreach($models->images as $key => $val) {
            @unlink($_SERVER['DOCUMENT_ROOT'] . $val);
        }
        $result = $model->delete();
        if($result){
          return json_encode('删除成功');
        } else {
          return json_encode('删除失败');
        }
    }

    /**
     * 批量删除
     */
    public function batch_delete(Request $request) {
      $ids = $request->post('ids');
      $ids_array = explode(',', $ids);
      foreach($ids_array as $val) {
        $model = PhotosModel::get($val);
        @unlink($_SERVER['DOCUMENT_ROOT'] . $model->image);
        foreach($models->images as $k => $v) {
            @unlink($_SERVER['DOCUMENT_ROOT'] . $v);
        }
        $result = $model->delete();
      }
      if($result){
        return json_encode('删除成功');
      } else {
        return json_encode('删除失败');
      }
    }

    /**
     * 批量转移
     */
    public function change_taxon(Request $request) {
      $tid = $request->post('tid');
      $ids = $request->post('ids');
      $ids_array = explode(',', $ids);
      $result = PhotosModel::whereIn('id', $ids_array)->update(['tid' => $tid]);
      if($result){
        return json_encode('转移成功');
      } else {
        return json_encode('转移失败');
      }
    }
}
