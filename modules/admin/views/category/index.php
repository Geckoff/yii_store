<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="pull-right">
        <?=Html::beginForm(['/admin/category/index'],'get');?>
            <input class="form-control search-admin" type="text" placeholder="Search" name='q'/>
            <?=Html::submitButton('<i class="fa fa-search admin-search-icon" aria-hidden="true"></i> <span class="admin-search-text">Search</span>', ['class' => 'btn btn-info',]);?>
        <?= Html::endForm();?>
    </div>


    <?=Html::beginForm(['/admin/category'], 'post', ['id' => 'grid-form']);?>

    <p>
        <div id='sort-name' data-name="<?=$sort ?>"></div>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Categories Order', ['order'], ['class' => 'btn btn-info', 'data-toggle' => 'modal', 'data-target' => '#categoryModal']) ?>
       <span class="checked-title">Checked Items:</span>
        <?=Html::button('<i class="fa fa-trash-o"></i>', ['class' => 'admin-checked-btn btn btn-danger disabled', 'disabled' => 'disabled', 'id' => 'del-checked', 'data-action' => 'delete-check']);?>
        <button type="button" data-action='set-vis-checked' class="admin-checked-btn btn btn-warning disabled" disabled id="vis-checked"><i class="fa fa-eye" aria-hidden="true"></i></button>
        <button type="button" data-action='set-unvis-checked' class="admin-checked-btn btn btn-warning disabled" disabled id="unvis-checked"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>

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
//            'parent_id',
            //'name',
            [
                'attribute' => 'name',
                'value' => function($data) {
                    return '<p><a href="'.\yii\helpers\Url::to(['category/update', 'id' => $data->id]).'">'.$data->name.'</a></p>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'name-column']
            ],
            [
                'attribute' => 'parent_id',
                'value' => function($data) {
                    return $data->category->name ? $data->category->name : '<span style="color: #ccc">Top Level Category</span>';
                },
                'format' => 'html'
            ],

            [
                'attribute' => 'active',
                'value' => function($data){
                    if ($data->active == 1) $class = 'fa-eye';
                    else $class = 'fa-eye-slash';
                    return '<a class="update-visibility" href="'.\yii\helpers\Url::to(['category/vis-update', 'id' => $data->id, 'vis' => $data->active]).'"><i class="fa '.$class.'" aria-hidden="true"></i>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'delete-column text-center active-column'],
                'headerOptions' => ['class' => 'text-center active-column'],
            ],

            [
                'value' => function($data){
                    return '<a class="delete-product" href="'.\yii\helpers\Url::to(['category/delete', 'id' => $data->id]).'"><i class="fa fa-trash-o" aria-hidden="true"></i>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'delete-column text-center id-column'],
                'headerOptions' => ['class' => 'id-column'],
            ],
        ],
    ]); ?>
    <?= Html::endForm();?>
</div>


<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="fa-stack">
                        <i class="fa fa-circle-thin fa-stack-2x"></i>
                        <i class="fa fa-times fa-stack-1x"></i>
                    </span>
                </button>
                <ul class="catalog-admin category-products-admin ul-menu-admin-order">
                <?= \app\components\MenuWidget::widget(['tpl' => 'order']) ?>
                </ul>
            </div>
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
