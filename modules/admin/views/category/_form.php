<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // echo $form->field($model, 'parent_id')->textInput(['maxlength' => true]) ?>

    <?php //echo $form->field($model, 'parent_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Category::find()->all(), 'id', 'name')); ?>
    <div class="admin-cat-brand">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <div class="form-group field-category-parent_id has-success">
            <label class="control-label" for="category-parent_id">Parent</label>
            <select id="category-parent_id" class="form-control" name="Category[parent_id]">
                <option value="0">Top Level Category</option>
                <?= app\components\MenuWidget::widget(['tpl' => 'select', 'model' => $model, 'category_add' => $category_add]) ?>
            </select>
        </div>
    </div>
    <div class="clearfix"></div>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'description')->textArea(['rows' => '4'])->label('Meta Description') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
