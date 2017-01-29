<?php

namespace app\components;

use yii\base\Widget;
use app\models\Brand;
use Yii;

/**
* Brands list.
* $type = barelist for building menu list.
* $type = select for building select tag.
**/

class BrandsWidget extends Widget  {

    public $type;
    public $id;
    public $product_id;

    public function init() {
        parent::init();
    }

    public function run() {

        $brands = Brand::find()->asArray()->with('products')->all();
        $html = '';
        if ($this->type == 'barelist'){
            foreach ($brands as $brand) {
                if (!empty($this->id)) {
                    $brand_id = is_array($this->id) ? $this->id['brand_id'] : $this->id;

                    if ($brand_id == $brand['id'] ) $active = 'class="active"';
                    else $active = '';
                }
                else $active = '';
                $html .= '<li><a href="'.\yii\helpers\Url::to(['brand/view', 'slug' => $brand['slug']]).'" '.$active.'>'.$brand['name'].'</a></li>';
            }
        }
        elseif ($this->type == 'select'){
            foreach ($brands as $brand) {
                if (!empty($this->id)) {
                    if ($brand['id'] == $this->id) $selected = 'selected';
                    else $selected = '';
                }
                else $selected = '';
                $html .= '<option value="'.$brand['id'].'" '.$selected.'>'.$brand['name'].'</option>';
            }
        }
        else {
            foreach ($brands as $brand) {
                if (!empty($this->id)) {
                    $brand_id = is_array($this->id) ? $this->id['brand_id'] : $this->id;

                    if ($brand_id == $brand['id'] ) $active = 'class="active"';
                    else $active = '';
                }
                else $active = '';
                $html .= '<li><a href="'.\yii\helpers\Url::to(['brand/view', 'slug' => $brand['slug']]).'" '.$active.'> <span class="pull-right">('.count($brand['products']).')</span>'.$brand['name'].'</a></li>';
            }
        }
        return $html;

    }

}