<?php
namespace app\backend\controller;

use think\Controller;
use think\Session;
use taxon\TaxonTree;
use app\common\model\Taxons as TaxonsModel;

class Application extends Controller
{
    public function _initialize()
    {
      $is_login = Session::has('user_name');
      if(!$is_login) {
        $this->error('请登录！', '/backend/login'); 
      }
      $this->assign('taxon_trees', $this->get_taxons_tree());
    }
    
    protected function get_taxons() {
      $list = TaxonsModel::all();
      $tree = new TaxonTree($list);
      $list = $tree->buildList();
      return $list;
    }

    protected function get_taxons_tree() {
      $list = TaxonsModel::all();
      $tree = new TaxonTree($list);
      $list = $tree->buildTree();
      return $list;
    }
}
