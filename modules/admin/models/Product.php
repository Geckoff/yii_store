<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property string $id
 * @property string $category_id
 * @property string $name
 * @property string $content
 * @property double $price
 * @property string $keywords
 * @property string $description
 * @property string $img
 * @property string $hit
 * @property string $new
 * @property string $sale
 */
class Product extends \yii\db\ActiveRecord
{

    public $image;
    public $gallery;
    public $euros;
    public $pounds;

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ],
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
        return 'product';
    }

    public function getCategory() {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getBrand() {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'slug', 'price'], 'required'],
            [['category_id', 'brand_id', 'rating','voters', 'active'], 'integer'],
            [['current_rating'], 'number', 'min' => 0,'max' => 5],
            [['content', 'hit', 'new', 'sale'], 'string'],
            [['price', 'order'], 'number'],
            [['name', 'keywords', 'description', 'img', 'slug'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'png, jpg'],
            [['gallery'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Product ID',
            'category_id' => 'Category',
            'brand_id' => 'Brand',
            'name' => 'Name',
            'content' => 'Content',
            'price' => 'Price',
            'keywords' => 'Keywords',
            'description' => 'Description',
            'image' => 'Image',
            'hit' => 'Hit',
            'new' => 'New',
            'sale' => 'Sale',
            'rating' => "Overall Raiting",
            'current_rating' => 'Average Rating',
            'active' => 'Visible'
        ];
    }

    public function upload() {
        if ($this->validate()) {
            $path = 'upload/store/'.$this->image->baseName.'.'.$this->image->extension;
            $this->image->saveAs($path);
            $this->attachImage($path, true);
            @unlink($path);
            return true;
        }
        else {
            return false;
        }
    }

    public function uploadGallery() {
        if ($this->validate()) {

            foreach($this->gallery as $file) {
                $path = 'upload/store/'.$file->baseName.'.'.$file->extension;
                $file->saveAs($path);
                $this->attachImage($path);
                @unlink($path);
            }
            return true;
        }
        else {
            return false;
        }
    }
}
