<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\PostAsset;
PostAsset::register($this);

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="pull-right">
        <?=Html::beginForm(['/admin/post/index'],'get');?>
            <input class="form-control search-admin" type="text" placeholder="Search" name='q'/>
            <?=Html::submitButton('Search', ['class' => 'btn btn-info',]);?>
        <?= Html::endForm();?>
    </div>
    <?=Html::beginForm(['/admin/post'], 'post', ['id' => 'grid-form']);?>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Posts Order', ['order'], ['class' => 'btn btn-info', 'data-toggle' => 'modal', 'data-target' => '#postModal']) ?>
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
                'checkboxOptions' => function($model) {
                    return ['value' => $model->id];
                },
                'contentOptions' => ['class' => 'check-column'],
            ],

            [
                 'attribute' => 'id',
                 'label' => 'ID',
                 'contentOptions' => ['class' => 'id-column'],
                 'headerOptions' => ['class' => 'check-column'],
            ],
            [
                'attribute' => 'name',
                'value' => function($data) {
                    return '<p><a href="'.\yii\helpers\Url::to(['post/update', 'id' => $data->id]).'">'.$data->name.'</a></p>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'name-column']
            ],
            // 'location',
            [
                'attribute' => 'location',
                'value' => function($data) {
                    switch ($data->location) {
                        case 1:
                            return "<span class='text-warning'>Footer</span>";
                            break;
                        case 2:
                            return "<span class='text-primary'>Header</span>";
                            break;
                        case 3:
                            return "<span class='text-success'>Header/Footer</span>";
                            break;
                    }
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'text-center'],
            ],

            [
                'attribute' => 'active',
                'value' => function($data){
                    if ($data->active == 1) $class = 'fa-eye';
                    else $class = 'fa-eye-slash';
                    return '<a class="update-visibility" href="'.\yii\helpers\Url::to(['post/vis-update', 'id' => $data->id, 'vis' => $data->active]).'"><i class="fa '.$class.'" aria-hidden="true"></i>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'delete-column text-center active-column'],
                'headerOptions' => ['class' => 'text-center active-column'],
            ],

            [
                'value' => function($data){
                    return '<a class="delete-product" href="'.\yii\helpers\Url::to(['post/delete', 'id' => $data->id]).'"><i class="fa fa-trash-o" aria-hidden="true"></i>';
                },
                'format' => 'html',
                'contentOptions' => ['class' => 'delete-column text-center id-column'],
                'headerOptions' => ['class' => 'id-column'],
            ],
        ],
    ]); ?>
    <?= Html::endForm();?>
</div>

<div class="modal fade" id="postModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="fa-stack">
                        <i class="fa fa-circle-thin fa-stack-2x"></i>
                        <i class="fa fa-times fa-stack-1x"></i>
                    </span>
                </button>
                <h2 class="post-order-title">Drag items to set the order</h2>
                <ul id="sortable" class="post-order-ul">
                <?php foreach ($model as $post):?>


                      <li class="ui-state-default post-order-li" id="<?=$post->id?>"><?=$post->name?></li>
                <?php endforeach; ?>
                </ul>
                <?= yii\bootstrap\Button::widget(['label' => 'Save', 'options' => ['class' => 'btn btn-success save-post-order']]) ?>
            </div>
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->                                                                                       
