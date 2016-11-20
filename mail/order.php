<div class="table-responsive">
    <table class="table table-hover table-stripped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Sum</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($session['cart'] as $id => $item): ?>
            <tr>
                <td><?= $item['name'] ?></td><!--<?= \yii\helpers\Url::to(['product/view', 'id' => $id], true) ?> //link with domain name-->
                <td><?= $item['qty'] ?></td>
                <td><?= $item['price'] ?></td>
                <td><?= $item['price'] * $item['qty'] ?></td>
            </tr>
        <?php endforeach; ?>
            <tr>
                <td colspan="2">Items in the cart:</td>
                <td><?= $session['cart.qty'] ?></td>
            </tr>
            <tr>
                <td colspan="2">Final Price:</td>
                <td><?= $session['cart.sum'] ?></td>
            </tr>
        </tbody>
    </table>
</div>