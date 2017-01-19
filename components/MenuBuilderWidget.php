<?php

namespace app\components;
use yii\base\Widget;
use app\models\Post;

class MenuBuilderWidget extends Widget  {

    public $type;

    public function init() {
        parent::init();
    }

    public function run() {
        if ($this->type == 'header') $type = '1';
        if ($this->type == 'footer') $type = '2';
        $posts = Post::find()->where(['active' => '1'])->andWhere(['location' => [$type, '3']])->orderBy('order')->all();             
        $html = '';
        foreach ($posts as $post) {
            $href = \yii\helpers\Url::to(['post/view', 'slug' => $post->slug]);
            $active = ($href == $_SERVER['REQUEST_URI']) ? 'class="active"' : '';
            $html .= '<li><a href="'.$href.'" '.$active.'>'.$post->name.'</a></li>';
        }
        return $html;
    }
}