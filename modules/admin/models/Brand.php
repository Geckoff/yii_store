<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "brand".
 *
 * @property string $id
 * @property string $name
 * @property string $keywords
 * @property string $description
 * @property string $slug
 * @property string $sales
 */
class Brand extends \yii\db\ActiveRecord
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
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['description', 'sales'], 'string'],
            [['name'], 'string', 'max' => 50],
            [['keywords', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
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
            'keywords' => 'Keywords',
            'description' => 'Meta Description',
            'slug' => 'Slug',
            'sales' => 'Sales',
        ];
    }
}
