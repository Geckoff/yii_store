<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\helpers\Currency;
?>
<section id="advertisement">
		<div class="container">
			<img src="/images/shop/advertisement.jpg" alt="" />
		</div>
	</section>

	<section>
		<div class="container">
			<div class="row">
				<?= \app\components\LeftSideBarWidget::widget(['controller' => 'category', 'id' => $category->id]) ?>
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
                        <?php foreach ($gets as $get => $param): ?>
                            <div id="<?=$get ?>-val" data-val="<?=$param ?>"></div>
                        <?php endforeach; ?>
						<h2 class="cat-h2 title text-center"><?=$category->name ?></h2>
                        <?= \app\components\SelectSortWidget::widget(['gets' => $gets]) ?> 

                        <?php if (!empty($products)): ?>          <!--products output-->
                        <?php $i = 0; foreach ($products as $product): ?>
                            <?= \app\components\ItemCardWidget::widget(['product' => $product]) ?>
                        <?php $i++; ?>
                        <?php if($i % 3 == 0): ?>
                            <div class="clearfix"></div>
                        <?php endif; ?>
                        <?php endforeach; ?>                      <!--products output-->
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
					</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>