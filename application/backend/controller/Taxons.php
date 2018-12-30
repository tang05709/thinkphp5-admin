<?php

namespace app\backend\controller;

use app\backend\controller\Application;
use think\Request;
use taxon\TaxonTree;
use app\common\model\Taxons as TaxonsModel;

class Taxons extends Application
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data = [
            'list' => $this->get_taxons(),
            'webmodule' => config('webmodule')
        ];
        return view('index', $data);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create(Request $request)
    {
        $parent_id = empty($request->get('parent_id')) ? 0 : $request->get('parent_id');
        $list = TaxonsModel::all();
        $tree = new TaxonTree($list);
        $options = $tree->buildOptions();
        $data = [
            'webmodule' => config('webmodule'),
            'options' => $options,
            'parent_id' => $parent_id
        ];
        return view('create', $data);
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
        $validate = $this->validate($data, 'Taxons');
        if(true !== $validate){
            return $validate->getError();
        }
        $model = new TaxonsModel($data);
        $result = $model->allowField(true)->save();
        if($result){
            $this->success('新增成功', '/backend/taxons');
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
        $model = TaxonsModel::get($id);
        $data = [
            'model' => $model,
            'webmodule' => config('webmodule')
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
        $validate = $this->validate($data, 'Taxons');
        if(true !== $validate){
            return $validate->getError();
        }
        $model = new TaxonsModel();
        $result = $model->allowField(true)->save($data,['id' => $id]);
        if($result){
            $this->success('修改成功', '/backend/taxons');
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
        // 有子栏目不能删除
        $has_children = TaxonsModel::where('parent_id', $id)->count();
        if($has_children > 0) {
            return json_encode('该栏目下有子栏目，不能删除！', JSON_UNESCAPED_UNICODE);
        }
        $model = TaxonsModel::get($id);
        @unlink($_SERVER['DOCUMENT_ROOT'] . $model->icon);
        $result = $model->delete();
        if($result){
            return json_encode('删除成功');
        } else {
            return json_encode('删除失败');
        }
    }

}
