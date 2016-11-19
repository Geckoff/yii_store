<?php

namespace app\models;
use yii\db\ActiveRecord;

class Product extends ActiveRecord {

    public static function tableName() {
        return 'product';
    }

    // setting relation with Product table.
    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']); // first param - dependent table name, second - field in dependent table
    }
}