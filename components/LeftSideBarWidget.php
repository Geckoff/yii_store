<?php

namespace app\components;
use yii\base\Widget;

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