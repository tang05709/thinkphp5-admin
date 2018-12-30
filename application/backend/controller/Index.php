<?php
namespace app\backend\controller;

use app\backend\controller\Application;
use think\Request;
use app\common\model\Taxons as TaxonsModel;
use taxon\TaxonTree;

class Index extends Application
{
    public function index()
    {
        return view('index');
    }

    public function get_move_module(Request $request) {
        $module = $request->post('module');
        $taxons = $this->get_taxons();
        $tree = new TaxonTree($taxons);
        $module_list = $tree->get_module_list($module);
        return json_encode($module_list);
    }
}
