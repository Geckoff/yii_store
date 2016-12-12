<?php

namespace app\models;
use yii\db\ActiveRecord;

class Parameter extends ActiveRecord {

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    public static function tableName() {
        return 'parameter';
    }
}