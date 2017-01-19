<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="card-rating">
        <div class="rating-data" data-cur="<?= $model->current_rating ?>"></div>
        <select class="example-fontawesome-o" >
            <option value=""></option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
    </div>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php
        $img = $model->getImage();
        $gallery = $model->getImages();
        $img_html = "<img class='admin-item-img' src='".$img->getUrl()."'>";
        $first = true;
        foreach ($gallery as $gal_img) {
            if ($first) {
               $first = false;
               continue;
            }
            $img_html .= "<img class='admin-item-img' src='".$gal_img->getUrl('100x100')."'>";
        }
    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'category_id',
            [
                'attribute' => 'category_id',
                'value' => $model->category->name,
                'format' => 'html'
            ],
            [
                'attribute' => 'brand_id',
                'value' => $model->brand->name,
                'format' => 'html'
            ],
            'name',
            //'content:html',
            [
                'attribute' => 'Item Description',
                'value' => $model->content,
                'format' => 'html'
            ],
            //'price',
            [
                'attribute' => 'price',
                'value' => "&#36;{$model->price} (<span class='secondary-price'>&euro;".round($model->euros, 2).", &pound;".round($model->pounds, 2)."</span>)",
                'format' => 'html'
            ],

//            'img',
            [
                'attribute' => 'image',
                'value' => $img_html,

                'format' => 'html'
            ],
//            'hit',
            [
                'attribute' => 'hit',
                'value' => !$model->hit ? '<span class="text-danger">No</span>' : '<span class="text-success">Yes</span>',
                'format' => 'html'
            ],
//            'new',
            [
                'attribute' => 'new',
                'value' => !$model->new ? '<span class="text-danger">No</span>' : '<span class="text-success">Yes</span>',
                'format' => 'html'
            ],
//            'sale',
            [
                'attribute' => 'sale',
                'value' => !$model->sale ? '<span class="text-danger">No</span>' : '<span class="text-success">Yes</span>',
                'format' => 'html'
            ],
            'rating',
            'voters',
            'current_rating',
            'keywords',
            //'description',
            [
                'attribute' => 'Meta Description',
                'value' => $model->description,
                'format' => 'html'
            ],
        ],
    ]) ?>


</div>
