<?php use yii\helpers\Html;   ?>

<div class="col-sm-3">
	<div class="left-sidebar">
        <div class="left-side-menu">
    		<h2>Category</h2>
            <ul class="catalog category-products">
                <a class="left-menu-dropdown" href="#left-menu-collapse-1"   data-toggle="collapse" aria-controls="left-menu-collapse-1"  aria-expanded="false">
                    <?=Html::img('@web/images/home/rolldown.png', ['alt' => 'rolldown']) ?>
                </a>
                <div class="left-ul-wrap" id="left-menu-collapse-1">
                <?php
                    if ($this->controller == 'category' || $this->controller == 'product') $array = ['tpl' => 'menu', 'id' => $this->id];
                    elseif (!$this->controller || $this->controller == 'brand') $array = ['tpl' => 'menu', 'id' => '0'];
                    else $array = ['tpl' => 'menu'];
                ?>
                <?= \app\components\MenuWidget::widget($array) ?>
                </div>
            </ul>
        </div>
		<div class="left-side-menu brands_products"><!--brands_products-->
			<h2>Brands</h2>
			<div class="brands-name">
				<ul class="nav nav-pills nav-stacked">
                    <a class="left-menu-dropdown" href="#left-menu-collapse-2"   data-toggle="collapse" aria-controls="left-menu-collapse-2"  aria-expanded="false">
                        <?=Html::img('@web/images/home/rolldown.png', ['alt' => 'rolldown']) ?>
                    </a>
                    <div class="left-ul-wrap" id="left-menu-collapse-2">
                    <?php
                        if ($this->controller == 'brand' || $this->controller == 'product') $id = ['id' => $this->id];
                    ?>
					<?= \app\components\BrandsWidget::widget($id) ?>
                    </div>
				</ul>
			</div>
		</div><!--/brands_products-->

		<div class="price-range"><!--price-range-->
			<h2>Price Range</h2>
			<div class="well">
				 <?= \app\components\PriceRangeWidget::widget(['controller' => $this->controller, 'id' => $this->id]) ?>
			</div>
		</div><!--/price-range-->

		<!--shipping-->
            <?php foreach ($graphics as $graphic):?>
                <?php if ($graphic->id == 5): ?>
                <div class="shipping shipping-mobile text-center">
                <?php else: ?>
                <div class="shipping shipping-desktop text-center">
                <?php endif; ?>
                <?php $img = $graphic->getImage();  ?>
                    <?php if ($graphic->link):?>
                    <a href="<?=$graphic->link?>"><?= Html::img($img->getUrl()) ?></a>
                    <?php else: ?>
                    <?= Html::img($img->getUrl()) ?>
                    <?php endif; ?>       
                </div>
            <?php  endforeach; ?>
		<!--/shipping-->

	</div>
</div>