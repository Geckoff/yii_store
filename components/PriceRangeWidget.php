<?php

namespace app\components;

use yii\base\Widget;
use app\models\Product;
use app\models\Category;
use app\models\Brand;
use app\helpers\Currency;
use Yii;

/**
* Price range filter.
* Front end side built on jquery-ui basis
**/

class PriceRangeWidget extends Widget  {

    public $controller;
    public $id;

    public function init() {
        parent::init();
    }

    public function run() {
        if ($this->controller == 'category' || $this->controller == 'brand') {   // Certain Brand or Category page
            if ($this->controller == 'category') {
                $controller_name = Category::findOne($this->id);
            }
            else {
                $controller_name = Brand::findOne($this->id);
            }
            $range_name = $controller_name->name;
            $max_product = Product::find()->where([$this->controller.'_id' => $this->id])->asArray()->max('price');
            $min_product = Product::find()->where([$this->controller.'_id' => $this->id])->asArray()->min('price');
        }
        else {        // Main or other than certain Brand or Category page
            $max_product = Product::find()->asArray()->max('price');
            $min_product = Product::find()->asArray()->min('price');
            $range_name = 'All Items';
        }
        /**
        * Max and min range values
        **/
        $max_product = Currency::getBarePrice($max_product, false, ceil);      // getting price in current currency
        $min_product = Currency::getBarePrice($min_product, true, floor);      // getting price in current currency
        if (Yii::$app->request->get('min') || Yii::$app->request->get('max')) {
            /**
            * Current range values
            **/
            $slider_val_min = Yii::$app->request->get('min');
            $slider_val_max = Yii::$app->request->get('max');
        }
        else {
            $slider_val_min = $min_product;
            $slider_val_max = $max_product;
        }
        $html = '<p class="range-name">'.$range_name.'<p>
                <div class="range-hide">
                    <input type="text" class="span2" value="" data-slider-min="'.$min_product.'" data-slider-max="'.$max_product.'" data-slider-step="5" data-slider-value="['.$slider_val_min.','.$slider_val_max.']" id="sl2" >
                    <br /><b class="pull-left">'.$min_product.'</b> <b class="pull-right">'.$max_product.'</b>
                </div>
                <p>
                  <input type="text" id="amount" readonly">
                </p>
                <p class="range-min-product">'.$min_product.'</p>
                <p class="range-max-product">'.$max_product.'</p>
                <div id="slider-range"></div>';
        return $html;
    }

}