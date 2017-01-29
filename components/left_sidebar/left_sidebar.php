<?php use yii\helpers\Html;   ?>

<div class="col-sm-3">
	<div class="left-sidebar">
		<h2>Category</h2>

                    <ul class="catalog category-products">
                    <?php
                        if ($this->controller == 'category' || $this->controller == 'product') $array = ['tpl' => 'menu', 'id' => $this->id];
                        elseif (!$this->controller || $this->controller == 'brand') $array = ['tpl' => 'menu', 'id' => '0'];
                        else $array = ['tpl' => 'menu'];
                    ?>
                    <?= \app\components\MenuWidget::widget($array) ?>
                    </ul>

		<div class="brands_products"><!--brands_products-->
			<h2>Brands</h2>
			<div class="brands-name">
				<ul class="nav nav-pills nav-stacked">
                    <?php
                        if ($this->controller == 'brand' || $this->controller == 'product') $id = ['id' => $this->id];
                    ?>
					<?= \app\components\BrandsWidget::widget($id) ?>
				</ul>
			</div>
		</div><!--/brands_products-->

		<div class="price-range"><!--price-range-->
			<h2>Price Range</h2>
			<div class="well">
				 <?= \app\components\PriceRangeWidget::widget(['controller' => $this->controller, 'id' => $this->id]) ?>
			</div>
		</div><!--/price-range-->

		<div class="shipping text-center"><!--shipping-->
			<?php if ($graphic->link):?>
                <a href="<?=$graphic->link?>"><?= Html::img($img->getUrl()) ?></a>
            <?php else: ?>
                <?= Html::img($img->getUrl()) ?>
            <?php endif; ?>
		</div><!--/shipping-->

	</div>
</div>