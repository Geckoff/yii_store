<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\helpers\Currency;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?><?php if ($category_page) echo '&nbsp;<span style="color: #ccc">('.$category_page.')</span>'?></h1>
    <div class="pull-right">
        <?=Html::beginForm(['/admin/product/index'],'get');?>
            <input class="form-control search-admin" type="text" placeholder="Search" name='q'/>
            <?=Html::submitButton('Search', ['class' => 'btn btn-info',]);?>
        <?= Html::endForm();?>
    </div>
    <?=Html::beginForm(['/admin/product'], 'post', ['id' => 'grid-form']);?>

    <p>
        <div id='sort-name' data-name="<?=$sort ?>"></div>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
        <span class="checked-title">Checked Items:</span>
        <?=Html::button('<i class="fa fa-trash-o"></i>', ['class' => 'admin-checked-btn btn btn-danger disabled', 'disabled' => 'disabled', 'id' => 'del-checked', 'data-action' => 'delete-check']);?>
        <button type="button" data-action='set-vis-checked' class="admin-checked-btn btn btn-warning disabled" disabled id="vis-checked"><i class="fa fa-eye" aria-hidden="true"></i></button>
        <button type="button" data-action='set-unvis-checked' class="admin-checked-btn btn btn-warning disabled" disabled id="unvis-checked"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
        <span class="checked-title">Category (<span id="checked-span-tooltip" data-toggle="tooltip" title="Choose Category to change order of the items.">?</span>):</span>
        <select id="product-category_id" class="admin-index-category form-control" name="Product[category_id]">
            <?= app\components\MenuWidget::widget(['tpl' => 'select', 'category_id' => $cat_id]) ?>
        </select>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'product-gridview-table',
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function($model) {
                    return ['value' => $model->id];
                },
                'contentOptions' => ['class' => 'check-column'],
            ],
            [
                'attribute' => 'order',
                'value' => function($data) use($min_order, $max_order) {
                    if ($data->order == $min_order) $up_arrow = '<a href="#"><i style="color: #ccc" class="fa fa-chevron-up" aria-hidden="true"></i></a>';
                    else  $up_arrow = '<a href="'.\yii\helpers\Url::to(['product/set-arrow-order', 'updown' => 'up', 'cur_order' => $data->order, 'id' => $data->id, 'cat_id' => $data->category_id]).'"><i class="fa fa-chevron-up" aria-hidden="true"></i></a>';
                    if ($data->order == $max_order) $down_arrow = '<a href="#"><i style="color: #ccc" class="fa fa-chevron-down" aria-hidden="true"></i></a>';
                    else $down_arrow = '<a href="'.\yii\helpers\Url::to(['product/set-arrow-order', 'updown' => 'down', 'cur_order' => $data->order, 'id' => $data->id, 'cat_id' => $data->category_id]).'"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>';
                    return  $up_arrow.
                            '<input data-controller="product" data-cur_order="'.$data->order.'" data-cat_id="'.$data->category_id.'" data-id="'.$data->id.'" class="form-control order-item" data-page="product" value="'.$data->order.'" type="text" name="id">'
                            .$down_arrow;
                },
                'format' => 'raw',
                'visible' => $category_page,
                'contentOptions' => ['class' => 'order-cell']
            ],
            [
                 'attribute' => 'id',
                 'label' => 'ID',
                 'contentOptions' => ['class' => 'id-column'],
                 'headerOptions' => ['class' => 'check-column'],
            ],
//            'category_id',
            [
                'attribute' => 'category_id',
                'value' => function($data) {
                    return $data->category->name;
                }
            ],

            //'name',
            [
                'attribute' => 'name',
                'value' => function($data) {
                    return '<p><a href="'.\yii\helpers\Url::to(['product/update', 'id' => $data->id]).'">'.$data->name.'</a></p>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'name-column']
            ],
//            'content:ntext',
            //'price',
            [
                'attribute' => 'price',
                'value' => function($data) {
                    $pounds = round($data->pounds, 2);
                    $euros = round($data->euros, 2);
                    return "<span class='main-price'>&#36;{$data->price}</span><br><span class='secondary-price'>&euro;$euros</span><br><span class='secondary-price'>&pound;$pounds</span>";
                },
                'format' => 'html'
            ],
            // 'keywords',
            // 'description',
            //'img',
            [
                'attribute' => 'img',
                'value' => function($data) {
                    $mainImg = $data->getImage();
                    return Html::img($mainImg->getUrl('60x60'), ['alt' => $data->name]);
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center'],
            ],
            // 'hit',
            [
                'attribute' => 'hit',
                'value' => function($data) {
                    return !$data->hit ? '<span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i></span>' : '<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center'],
            ],
            // 'new',
            [
                'attribute' => 'new',
                'value' => function($data) {
                    return !$data->new ? '<span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i></span>' : '<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center'],
            ],
            // 'sale',
            [
                'attribute' => 'sale',
                'value' => function($data) {
                    return !$data->sale ? '<span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i></span>' : '<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center'],
            ],
            'voters',
            //'current_rating',
            [
                'attribute' => 'current_rating',
                'value' => function($data) {
                    $int_rating = floor($data->current_rating);
                    $frac_rating = ($data->current_rating - $int_rating) * 10;
                    if ($data->current_rating == 0) $current_rating = '&ndash;';
                    else  $current_rating = $data->current_rating;
                    $stars = "<span>$current_rating</span><br>";
                    for ($i = 0; $i < $int_rating; $i++) {
                        $stars .= '<i class="fa fa-star" aria-hidden="true"></i>';
                    }
                    if ($frac_rating > 0) {
                        $stars .= '<i class="fa fa-star-half-o" aria-hidden="true"></i>';
                        $subtr_star = 1;
                    }
                    else $subtr_star = 0;
                    $empty_stars = 5 - $int_rating - $subtr_star;
                    for ($i = 0; $i < $empty_stars; $i++) {
                        $stars .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
                    }
                    return $stars;
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'rating-column text-center'],
                'headerOptions' => ['class' => 'text-center'],
            ],

            [
                'attribute' => 'active',
                'value' => function($data){
                    if ($data->active == 1) $class = 'fa-eye';
                    else $class = 'fa-eye-slash';
                    return '<a class="update-visibility" href="'.\yii\helpers\Url::to(['product/vis-update', 'id' => $data->id, 'vis' => $data->active]).'"><i class="fa '.$class.'" aria-hidden="true"></i>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'delete-column text-center active-column'],
                'headerOptions' => ['class' => 'text-center active-column'],
            ],

            [
                'value' => function($data){
                    return '<a class="delete-product" href="'.\yii\helpers\Url::to(['product/delete', 'id' => $data->id]).'"><i class="fa fa-trash-o" aria-hidden="true"></i>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'delete-column text-center id-column'],
                'headerOptions' => ['class' => 'id-column'],
            ],

        ],
    ]); ?>
    <?= Html::endForm();?>
</div>
