<?php
use yii\helpers\Html;
$this->title = 'Options'; 
?>
<h1>Options</h1>

<?= $form = Html::beginForm($action = '/admin/parameter/update', 'post', ['class' => 'param-form']); ?>

<?php foreach ($options as $major_key => $option): ?>
<?php if (is_array($option['value'])):?>
    <h3><?= $option['title'] ?></h3>
    <?php foreach ($option['value'] as $minor_key => $value):?>
    <div class="form-group field-product-name required">
        <?= Html::label($value['title'], $for = $major_key.'['.$minor_key.']')?>
        <?= Html::textInput ($major_key.'[value]['.$minor_key.'][value]', $value['value'], ['class' => 'form-control', 'id' => $major_key.'['.$minor_key.']']) ?>
        <?= Html::hiddenInput ($major_key.'[value]['.$minor_key.'][type]', $value['type']) ?>
        <?= Html::hiddenInput ($major_key.'[value]['.$minor_key.'][title]', $value['title']) ?>
        <div class="help-block"></div>
    </div>
    <?php endforeach ?>
<?php else: ?>
    <div class="form-group field-product-name required">
        <?= Html::label($option['title'], $for = $major_key)?>
        <?= Html::textInput ($major_key.'[value]', $option['value'], ['class' => 'form-control']) ?>
        <?= Html::hiddenInput ($major_key.'[type]', $option['type']) ?>
        <?= Html::hiddenInput ($major_key.'[title]', $option['title']) ?>
        <div class="help-block"></div>
    </div>
<?php endif ?>



<?php endforeach; ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>
<?= Html::endForm() ?>
