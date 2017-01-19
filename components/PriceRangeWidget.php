<?php

namespace app\components;

use yii\base\Widget;
use app\models\Product;
use app\models\Category;
use app\models\Brand;
use app\helpers\Currency;
use Yii;

class PriceRangeWidget extends Widget  {

    public $controller;
    public $id;

    public function init() {
        parent::init();
    }

    public function run() {
        if ($this->controller == 'category' || $this->controller == 'brand') {
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
        else {
            $max_product = Product::find()->asArray()->max('price');
            $min_product = Product::find()->asArray()->min('price');
            $range_name = 'All Items';
        }
        $max_product = Currency::getBarePrice($max_product, false, ceil);
        $min_product = Currency::getBarePrice($min_product, true, floor);
        if (Yii::$app->request->get('min') || Yii::$app->request->get('max')) {
            $slider_val_min = Yii::$app->request->get('min');
            $slider_val_max = Yii::$app->request->get('max');
            /*$slider_val_min = Currency::getBarePrice($slider_val_min, true) + 1;
            $slider_val_max = Currency::getBarePrice($slider_val_max, true) + 1;*/
        }
        else {
            $slider_val_min = $min_product;
            $slider_val_max = $max_product;
        }                                 
        $html = '<p>'.$range_name.'<p>
                <input type="text" class="span2" value="" data-slider-min="'.$min_product.'" data-slider-max="'.$max_product.'" data-slider-step="5" data-slider-value="['.$slider_val_min.','.$slider_val_max.']" id="sl2" >
                <br /><b class="pull-left">'.$min_product.'</b> <b class="pull-right">'.$max_product.'</b>';
        return $html;
    }

}