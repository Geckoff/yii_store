<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="info-section order-update-date">
        <div class="info-label">Order Date:</div>
        <p><?=$model->created_at ?></p>
        <div class="info-label">Update Date:</div>
        <p><?=$model->updated_at ?></p>
    </div>
    <div class="clearfix"></div>

    <div class="client-data-block">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control client-data']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'class' => 'form-control client-data']) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'class' => 'form-control client-data']) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'class' => 'form-control client-data']) ?>
    </div>
    <div class="clearfix"></div>

    <?php if ($model->note):?>
    <div class="form-group note-order">
        <label class="control-label" for="order-status">Client Note</label>
        <p><?=$model->note ?></p>
    </div>
    <?php endif; ?>
    <hr>

    <div class="info-section order-price-block">
        <div class="info-label">Quantity Of Items:</div>
        <p class="text-success"><?=$model->qty ?></p>
        <div class="info-label">Currency:</div>
        <p class="text-success"><?=$model->currency ?></p>
        <div class="info-label">Total Sum:</div>
        <?php $i = 0 ?>
        <?php foreach ($currency as $currency_unit): ?>
            <?php if ($i == 0):?>
                <span class="primary-price"><?=$currency_unit['sign'].$currency_unit['value'] ?></span>
                <?php $i = 1; ?>
            <?php else: ?>
                <span class="secondary-prices"><?=$currency_unit['sign'].$currency_unit['value'] ?></span>
            <?php endif; ?>
        <?php endforeach ?>

    </div>
    <div class="clearfix"></div>

    <div class="form-group order-product-table">

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Order Price Per Item</th>
                    <th>Full Order Price </th>
                    <th>Current Price Per Item</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product): ?>
            <?php $mainImg = $product->getImage();  ?>
                <tr>
                    <td><?=$product->id ?></td>
                    <td><a href="<?= \yii\helpers\Url::to(['/product/view', 'slug' => $product->slug]) ?>"><?=$product->name ?></a></td>
                    <td><?= Html::img($mainImg->getUrl('50x50')) ?></td>
                    <?php foreach ($model->orderItems as $item): ?>
                    <?php if ($item->product_id == $product->id):?>
                    <td><i><?=$item->qty_item ?></i></td>              
                    <td><strong><?=$currency[0]['sign'] ?><?=$item->price ?></strong></td>
                    <td><strong><?=$currency[0]['sign'] ?><?=$item->price * $item->qty_item ?></strong></td>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <td><span class="primary-price">$<?=$product->price ?></span> <span class="secondary-prices">&euro;<?=round($product->euros, 2) ?>&nbsp; &pound;<?=round($product->pounds, 2) ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?= $form->field($model, 'status')->dropDownList([ '0' => 'New', '1' =>'Active', '2' => 'Completed']/*, ['prompt' => '']*/) ?>

    <?= $form->field($model, 'admin_note')->textArea(['rows' => '4'])->label('Administrator Note') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
