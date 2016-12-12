<?php

namespace app\models;
use yii\db\ActiveRecord;

class Brand extends ActiveRecord {

    public static function tableName() {
        return 'brand';
    }

    // setting one to many relation with Product table.
    public function getProducts() {
        return $this->hasMany(Product::className(), ['brand_id' => 'id']); // second param - field in dependent table
    }
}