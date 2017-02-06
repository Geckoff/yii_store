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
        $graphics = Graphic::find()->where(['id' => [5, 6]])->all();     
        include __DIR__.'/left_sidebar/left_sidebar.php';
    }
}