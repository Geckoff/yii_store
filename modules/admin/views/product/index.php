<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="search_box pull-right">
        <?=Html::beginForm(['/admin/product/index'],'post');?>
            <input type="text" placeholder="Search" name='q'/>
            <?=Html::submitButton('Search', ['class' => 'btn btn-info',]);?>
        <?= Html::endForm();?>
    </div>
    <?=Html::beginForm(['/admin/product/delete-check'],'post');?>

    <p>
        <div id='sort-name' data-name="<?=$sort ?>"></div>
        <?= Html::a('Create Product', ['create'], ['class' => 'btn btn-success']) ?>
        <?=Html::submitButton('Delete Checked Items', ['class' => 'btn btn-danger disabled', 'disabled' => 'disabled', 'id' => 'del-checked']);?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function($model) {
                    return ['value' => $model->id];
                },
            ],

            //'id',
            [
                'attribute' => 'id',
                'label' => 'ID'
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
                    return '<p><a href="'.\yii\helpers\Url::to(['admin/product/view', 'id' => $data->id]).'">'.$data->name.'</a></p>';
                },
                'format' => 'html'
            ],
//            'content:ntext',
            'price',
            // 'keywords',
            // 'description',
            //'img',
            [
                'attribute' => 'img',
                'value' => function($data) {
                    $mainImg = $data->getImage();
                    return Html::img($mainImg->getUrl('50x50'), ['alt' => $data->name]);
                },
                'format' => 'html'
            ],
            // 'hit',
            [
                'attribute' => 'hit',
                'value' => function($data) {
                    return !$data->hit ? '<span class="text-danger">No</span>' : '<span class="text-success">Yes</span>';
                },
                'format' => 'html'
            ],
            // 'new',
            [
                'attribute' => 'new',
                'value' => function($data) {
                    return !$data->new ? '<span class="text-danger">No</span>' : '<span class="text-success">Yes</span>';
                },
                'format' => 'html'
            ],
            // 'sale',
            [
                'attribute' => 'sale',
                'value' => function($data) {
                    return !$data->sale ? '<span class="text-danger">No</span>' : '<span class="text-success">Yes</span>';
                },
                'format' => 'html'
            ],
            'voters',
            'current_rating',

            ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>
    <?= Html::endForm();?>
</div>
