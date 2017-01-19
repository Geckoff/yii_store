<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;
mihaildev\elfinder\Assets::noConflict($this);



/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'product-form']]); ?>


    <div class="form-group field-product-category_id">
        <label class="control-label" for="product-category_id">Category</label>
        <select id="product-category_id" class="form-control" name="Product[category_id]">
            <?= app\components\MenuWidget::widget(['tpl' => 'select', 'model' => $model]) ?>
        </select>
    </div>

    <div class="form-group field-product-brand_id">
        <label class="control-label" for="product-brand_id">Brand</label>
        <select id="product-brand_id" class="form-control" name="Product[brand_id]">
            <?= app\components\BrandsWidget::widget(['type' => 'select', 'id' => $model->brand_id]) ?>
        </select>
    </div>
    <div class="clearfix"></div>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php
    /*echo $form->field($model, 'content')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]);*/
    ?>

    <?php
    echo $form->field($model, 'content')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder',[/* Some CKEditor Options */]),
    ])->label('Description');
    ?>

    <?= $form->field($model, 'price')->textInput()->label('Price ($)') ?>

    <?= $form->field($model, 'hit')->checkBox([ '0', '1']) ?>

    <?= $form->field($model, 'new')->checkBox([ '0', '1', 'class' => 'new-sale']) ?>

    <?= $form->field($model, 'sale')->checkBox([ '0', '1', 'class' => 'new-sale' ]) ?>

    <?= $form->field($model, 'rating')->textInput() ?>
    <?= $form->field($model, 'voters')->textInput() ?>
    <?= $form->field($model, 'current_rating')->textInput(/*['disabled' => 'disabled']*/)->label('Avg. Rating (0 or between 1 and 5)') ?>
    <div class="clearfix"></div>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textArea(['rows' => '4'])->label('Meta Description') ?>

    <?= $form->field($model, 'image')->fileInput()->label('Main Image') ?>
    <?php $mainImg = $model->getImage();  ?>
    <div class="main-img-update">
        <?= Html::img($mainImg->getUrl('200x200')) ?>
    </div>


    <?= $form->field($model, 'gallery[]')->fileInput(['multiple' => true, 'accept' => 'image/*', 'id' => 'gallery-input']) ?>

    <?php if (!$model->isNewRecord): ?>
        <?php $gallery = $model->getImages();  ?>
        <?php if (count($gallery) !== 1): ?>
            <div data-itemid="<?=$model->id ?>" class="update-gallery">
            <?php $first = true; ?>
            <?php foreach($gallery as $gal_img): ?>
                <div class="single-update-gallery">
                    <!--<?php
                        if ($first) {
                            $first = false;
                            continue;
                        }
                    ?>-->
                    <?= Html::img($gal_img->getUrl('200x200')) ?>
                    <i data-id="<?=$gal_img->id ?>" class="fa fa-times-circle-o" aria-hidden="true"></i>
                </div>
            <?php endforeach; ?>
            </div>
            <div class="clearfix"></div>
        <?php else: ?>
            <div class="update-gallery"></div>
            <div class="clearfix"></div>
        <?php endif; ?>
    <?php else: ?>
        <div class="update-gallery"></div>
        <div class="clearfix"></div>
    <?php endif; ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success btn-lg' : 'btn btn-primary btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
