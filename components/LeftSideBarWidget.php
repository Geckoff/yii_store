<?php

namespace app\components;
use yii\base\Widget;

/**
* Left sidebar components.
* Includes MenuWidget, BrandsWidget and PriceRangeWidget.
**/

class LeftSideBarWidget extends Widget  {

    public $controller;
    public $id;

    public function init() {
        parent::init();
    }

    public function run() {
        include __DIR__.'/left_sidebar/left_sidebar.php';
    }
}