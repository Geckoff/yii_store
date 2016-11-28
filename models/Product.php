<?php

namespace app\models;
use yii\db\ActiveRecord;

class Product extends ActiveRecord {

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    public static function tableName() {
        return 'product';
    }

    // setting relation with Product table.
    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']); // second - field in dependent table
    }
}