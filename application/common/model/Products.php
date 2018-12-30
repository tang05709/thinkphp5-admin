<?php

namespace app\common\model;

use think\Model;

class Products extends Model
{
    protected $autoWriteTimestamp = true;

    public function setPriceAttr($value) {
        return intval($value);
    }
}
