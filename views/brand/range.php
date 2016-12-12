<?php use app\helpers\Currency;  ?>
<?php use yii\helpers\Html;  ?>
        <?php foreach ($gets as $get => $param): ?>
            <div id="<?=$get ?>-val" data-val="<?=$param ?>"></div>
        <?php endforeach; ?>
		<h2 class="title text-center"><?=$brand->name ?></h2>
        <?= \app\components\SelectSortWidget::widget(['gets' => $gets]) ?>

        <?php if (!empty($products)): ?>
        <?php $i = 0; foreach ($products as $item): ?>
		    <?= \app\components\ItemCardWidget::widget(['product' => $item]) ?>
        <?php $i++; ?>
        <?php if($i % 3 == 0): ?>
            <div class="clearfix"></div>
        <?php endif; ?>
        <?php endforeach; ?>
        <div class="clearfix"></div>
        <?php
        echo \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
        ]);
        ?>
        <?php else: ?>
            <h2>No products in current category</h2>
        <?php endif; ?>
        <div class="clearfix"></div>