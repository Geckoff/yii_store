<?php

namespace app\components;
use yii\base\Widget;

class ItemCardWidget extends Widget  {

    public $product;

    public function init() {
        parent::init();
    }

    public function run() {
        include __DIR__.'/item_card/item_card.php';
    }
}