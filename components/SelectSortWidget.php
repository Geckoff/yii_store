<?php

namespace app\components;
use yii\base\Widget;

/**
* Filters fot catalog products
**/

class SelectSortWidget extends Widget  {

    public $gets;

    public function init() {
        parent::init();
    }

    public function run() {
        include __DIR__.'/select_sort/select_sort.php';
    }
}