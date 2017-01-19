<?php

namespace app\modules\admin\models;

use Yii;


class Graphic extends \yii\db\ActiveRecord
{

    public $img;
    public $carousel;
  
    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'rico\yii2images\behaviors\ImageBehave',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'graphic';
    }

    public function getCarousel() {        // name of the attribute in model is orderItems
        return $this->hasOne(Carousel::className(), ['id' => 'carousel_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'link'], 'string', 'max' => 255],
            [['gallery_id', 'gallery'], 'integer'],
            [['img'], 'file', 'extensions' => 'png, jpg'],
            [['carousel'], 'file', 'extensions' => 'png, jpg', 'maxFiles' => 10],
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
            'link' => 'Link',
            'gallery' => 'Gallery',
            'gallery_id' => 'Gallery ID',
        ];
    }

    public function upload() {
        if ($this->validate()) {
            $path = 'upload/store/'.$this->img->baseName.'.'.$this->img->extension;
            $this->img->saveAs($path);
            $this->attachImage($path, true);
            @unlink($path);

            return true;
        }
        else {
            return false;
        }
    }

    /*public function upload() {
        if ($this->validate()) {
            $path = 'upload/store/'.$this->side_banner_img->baseName.'.'.$this->side_banner_img->extension;
            $this->side_banner_img->saveAs($path);
            $this->attachImage($path, true);
            @unlink($path);
            return true;
        }
        else {
            return false;
        }
    }*/

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
