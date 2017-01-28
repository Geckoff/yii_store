<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="pull-right">
        <?=Html::beginForm(['/admin/order/index'],'get');?>
            <input class="form-control search-admin" type="text" placeholder="Search" name='q'/>
            <?=Html::submitButton('Search', ['class' => 'btn btn-info',]);?>
        <?= Html::endForm();?>
    </div>

    <?=Html::beginForm(['/admin/order/delete-check'], 'post', ['id' => 'grid-form']);?>

    <p>
        <span class="checked-orders checked-title">Checked Items:</span>
        <?=Html::button('<i class="fa fa-trash-o"></i>', ['class' => 'admin-checked-btn btn btn-danger disabled', 'disabled' => 'disabled', 'id' => 'del-checked', 'data-action' => 'delete-check']);?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'contentOptions' => ['class' => 'check-column'],
            ],

            [
                 'attribute' => 'id',
                 'contentOptions' => ['class' => 'id-column'],
                 'headerOptions' => ['class' => 'check-column'],
            ],
            //'name',
            [
                'attribute' => 'name',
                'value' => function($data) {
                    return '<p><a href="'.\yii\helpers\Url::to(['order/update', 'id' => $data->id]).'">'.$data->name.'</a></p>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'name-column']
            ],
            'created_at',
            'updated_at',
            'qty',
            //'sum',
            [
                'attribute' => 'sum',
                'value' => function($data) {
                    return $data->currency.'&nbsp;'.$data->sum;
                },
                'format' => 'html',
            ],
            [
                'attribute' => 'status',
                'value' => function($data) {      // $data - data from ActiveDataProvider;
                    if ($data->status == 0) { $class = 'text-danger new-admin-order'; $title = 'New'; }
                    if ($data->status == 1) { $class = 'text-warning'; $title = 'Active'; }
                    if ($data->status == 2) { $class = 'text-success'; $title = 'Completed'; }
                    return '<span class="'.$class.'">'.$title.'</span>';
                },
                'format' => 'html'
            ],

            [
                'value' => function($data){
                    return '<a class="delete-product" href="'.\yii\helpers\Url::to(['order/delete', 'id' => $data->id]).'"><i class="fa fa-trash-o" aria-hidden="true"></i>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'delete-column text-center id-column'],
                'headerOptions' => ['class' => 'id-column'],
            ],

        ],
    ]); ?>
    <?= Html::endForm();?>
</div>
