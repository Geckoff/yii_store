<?php

namespace app\components;
use yii\base\Widget;
use app\models\Graphic;


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
        $graphic = Graphic::findOne(6);
        $img = $graphic->getImage();
        include __DIR__.'/left_sidebar/left_sidebar.php';
    }
}