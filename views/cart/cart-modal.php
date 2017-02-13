<?php
    use app\helpers\Currency;
    use yii\helpers\Html;
?>
<?php if (!empty($session['cart'])): ?>
        <div class="table-responsive">
            <table class="table table-hover table-stripped">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($items_to_show as $id => $item): ?>
                    <?php $mainImg = $item->getImage();   ?>
                    <tr>

                        <td><?= \yii\helpers\Html::img($mainImg->getUrl(), ['alt' => $item->name, 'height'=>'50px']) ?></td>
                        <td class="title-cart"><a href="<?=\yii\helpers\Url::to(['product/view', 'slug' => $product->slug]) ?>"><?= $item->name ?></a></td>
                        <td><?= $item->qty ?></td>
                        <td><?= Currency::getPrice($item->price, true);?></td>
                        <td><span data-id="<?= $id ?>" class="glyphicon glyphicon-remove text-danger del-item" aria-hidden="true"></span></td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td colspan="4">Items in the cart:</td>
                        <td><?= $session['cart.qty'] ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">Final Price:</td>
                        <td><?= Currency::getPrice($session['cart.sum'], true);?></td>
                    </tr>
                </tbody>
            </table>
        </div>
<?php else: ?>
    <h3>Cart is empty</h3>
<?php endif; ?>