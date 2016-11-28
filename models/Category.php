<?php

namespace app\models;
use yii\db\ActiveRecord;

class Category extends ActiveRecord {

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    public static function tableName() {
        return 'category';
    }

    // setting one to many relation with Product table.
    public function getProducts() {
        return $this->hasMany(Product::className(), ['category_id' => 'id']); // second param - field in dependent table
    }
}