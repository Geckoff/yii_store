<?php

namespace app\models;
use yii\db\ActiveRecord;

class Category extends ActiveRecord {

    public static function tableName() {
        return 'category';
    }

    // setting one to many relation with Product table.
    public function getProducts() {
        return $this->hasMany(Product::className(), ['category_id' => 'id']); // first param - dependent table name, second - field in dependent table
    }
}