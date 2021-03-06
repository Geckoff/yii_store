<?php

    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;
    use app\helpers\Currency;
?>

<div class="container">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo Yii::$app->session->getFlash('success'); ?>
    </div>

    <?php endif; ?>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <?php echo Yii::$app->session->getFlash('error'); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($session['cart'])): ?>
        <div class="table-responsive">
            <table class="table table-hover table-stripped"  id="cart-view">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Sum</th>
                        <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
                    </tr>
                </thead>
                <tbody>
                <?php ?>
                <?php foreach ($session['cart'] as $id => $item): ?>
                    <tr>
                        <td><?= \yii\helpers\Html::img($item['img'], ['alt' => $item['name'], 'height' => '50px'])  ?></td>
                        <td><a href="<?= \yii\helpers\Url::to(['product/view', 'id' => $id]) ?>"><?= $item['name'] ?></a></td>
                        <td><?= $item['qty'] ?></td>
                        <td><?= Currency::getPrice($item['price'], true);?></td>
                        <td><?= Currency::getPrice($item['price'], true, $item['qty']);?></td>
                        <td><span data-id="<?= $id ?>" class="glyphicon glyphicon-remove text-danger del-item" aria-hidden="true"></span></td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td colspan="5">Items in the cart:</td>
                        <td id="all-items"><?= $session['cart.qty'] ?></td>
                    </tr>
                    <tr>
                        <td colspan="5">Final Price:</td>
                        <td id="full-price"><?= Currency::getPrice($session['cart.sum'], true);?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($order, 'name') ?>
        <?= $form->field($order, 'email') ?>
        <?= $form->field($order, 'phone') ?>
        <?= $form->field($order, 'address') ?>
        <?= Html::submitButton('Leave Order', ['class' => 'btn btn-success']) ?>
        <?php ActiveForm::end(); ?>
<?php else: ?>
    <h3>Cart is empty</h3>
<?php endif; ?>
</div>