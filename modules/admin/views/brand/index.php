<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="pull-right">
        <?=Html::beginForm(['/admin/brand/index'],'get');?>
            <input class="form-control search-admin" type="text" placeholder="Search" name='q'/>
            <?=Html::submitButton('Search', ['class' => 'btn btn-info',]);?>
        <?= Html::endForm();?>
    </div>

    <?=Html::beginForm(['/admin/brand/delete-check'], 'post', ['id' => 'grid-form']);?>

    <p>
        <div id='sort-name' data-name="<?=$sort ?>"></div>
        <?= Html::a('Create Brand', ['create'], ['class' => 'btn btn-success']) ?>
        <span class="checked-title">Checked Items:</span>
        <?=Html::button('<i class="fa fa-trash-o"></i>', ['class' => 'admin-checked-btn btn btn-danger disabled', 'disabled' => 'disabled', 'id' => 'del-checked', 'data-action' => 'delete-check']);?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'contentOptions' => ['class' => 'check-column'],
                'headerOptions' => ['class' => 'check-column'],
            ],
            //'id',
            [
                 'attribute' => 'id',
                 'contentOptions' => ['class' => 'id-column'],
                 'headerOptions' => ['class' => 'check-column'],
            ],
            [
                'attribute' => 'name',
                'value' => function($data) {
                    return '<p><a href="'.\yii\helpers\Url::to(['brand/update', 'id' => $data->id]).'">'.$data->name.'</a></p>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'name-column'],
            ],
            // 'sales',
            [
                'attribute' => 'sales',
                'value' => function($data) {
                    return !$data->sales ? '<span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i></span>' : '<span class="text-success"><i class="fa fa-check" aria-hidden="true"></i></span>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center'],
            ],

            [
                'value' => function($data){
                    return '<a class="delete-product" href="'.\yii\helpers\Url::to(['brand/delete', 'id' => $data->id]).'"><i class="fa fa-trash-o" aria-hidden="true"></i>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'delete-column text-center id-column'],
                'headerOptions' => ['class' => 'id-column'],

            ],
        ],
    ]); ?>
    <?= Html::endForm();?>
</div>
