<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property string $id
 * @property string $slug
 * @property string $name
 * @property string $text
 * @property string $active
 * @property string $order
 * @property string $location
 */
class Post extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [    
            'slug' => [
    			'class' => 'app\behaviors\Slug',
    			'in_attribute' => 'name',
    			'out_attribute' => 'slug',
    			'translit' => true
    		]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['active'], 'integer'],
            [['order'], 'required'],
            [['order', 'location'], 'integer'],
            [['slug'], 'string', 'max' => 255],
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
            'slug' => 'Slug',
            'name' => 'Name',
            'text' => 'Text',
            'active' => 'Active',
            'order' => 'Order',
            'location' => 'Location',
        ];
    }
}
