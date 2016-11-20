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
                <?php foreach ($session['cart'] as $id => $item): ?>
                    <tr>
                        <td><?= \yii\helpers\Html::img('@web/images/products/'.$item['img'], ['alt' => $item['name'], 'height' => '50px'])  ?></td>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['qty'] ?></td>
                        <td><?= $item['price'] ?></td>
                        <td><span data-id="<?= $id ?>" class="glyphicon glyphicon-remove text-danger del-item" aria-hidden="true"></span></td>
                    </tr>
                <?php endforeach; ?>
                    <tr>
                        <td colspan="4">Items in the cart:</td>
                        <td><?= $session['cart.qty'] ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">Final Price:</td>
                        <td><?= $session['cart.sum'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
<?php else: ?>
    <h3>Cart is empty</h3>
<?php endif; ?>