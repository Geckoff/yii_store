<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "carousel".
 *
 * @property integer $id
 * @property string $name
 */
class Carousel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carousel';
    }

    public function getOrderGraphics() {
        return $this->hasMany(Graphic::className(), ['carousel_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
