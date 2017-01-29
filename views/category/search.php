<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\helpers\Currency;
?>
<section id="advertisement">
		<div class="container">
			<?php $img = $banner->getImage(); ?>
			<?php if ($banner->link):?>
                <a href="<?=$banner->link?>"><?= Html::img($img->getUrl('1410x')) ?></a>
            <?php else: ?>
                <?= Html::img($img->getUrl()) ?>
            <?php endif; ?>
		</div>
	</section>

	<section>
		<div class="container">
			<div class="row">
				<?= \app\components\LeftSideBarWidget::widget() ?>
                <div id="search-string" data-search="<?= $q ?>"></div>
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
                        <?php foreach ($gets as $get => $param): ?>
                            <div id="<?=$get ?>-val" data-val="<?=$param ?>"></div>
                        <?php endforeach; ?>
						<h2 class="title text-center">Search: <?=Html::encode($q)?></h2>
                        <?= \app\components\SelectSortWidget::widget(['gets' => $gets]) ?>

                        <?php if (!empty($products)): ?>
                        <?php $i = 0; foreach ($products as $product): ?>
						    <?= \app\components\ItemCardWidget::widget(['product' => $product]) ?>
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
                            <h2>No products found for current search :(</h2>
                        <?php endif; ?>
                        <div class="clearfix"></div>
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>