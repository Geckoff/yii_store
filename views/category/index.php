<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use app\helpers\Currency;
?>

<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>

						<div class="carousel-inner">
                        <?php $j = 0 ?>
                        <?php foreach ($carousel as $slide):?>
                            <?php $img = $slide->getImage(); ?>
							<div class="item <?php if ($j == 0) echo 'active' ?>">
                                <?php if ($slide->link):?>
                                    <a href="<?=$slide->link?>"><?= Html::img($img->getUrl()) ?></a>
                                <?php else: ?>
                                    <?= Html::img($img->getUrl('1410x')) ?>
                                <?php endif; ?>
							</div>
                            <?php $j++ ?>
                        <?php endforeach; ?>
						</div>

						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>

				</div>
			</div>
		</div>
	</section><!--/slider-->

	<section>
		<div class="container">
			<div class="row">
				<?= \app\components\LeftSideBarWidget::widget(['controller' => false]) ?>

				<div class="col-sm-9 padding-right">
                    <?php if(!empty($hits)): ?>
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Features Items</h2>
                        <?php foreach ($hits as $hit): ?>
						    <?= \app\components\ItemCardWidget::widget(['product' => $hit]) ?>
                        <?php endforeach; ?>
					</div><!--features_items-->
                    <?php endif; ?>
					<div class="category-tab"><!--category-tab-->
                        <h2 class="title text-center">Sales</h2>
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
                            <?php $i = 0; ?>
                            <?php foreach ($sales_brands as $sales_brand): ?>
								<li<?php if ($i == 0) echo ' class="active"'?>><a href="#brand-<?= $sales_brand['id']; ?>" data-toggle="tab"><?= $sales_brand['name']; ?></a></li>
                                <?php $i++; ?>
                            <?php endforeach; ?>
							</ul>
						</div>
						<div class="tab-content">
                            <?php $i = 0; ?>
                            <?php foreach($brand_sales_products as $id => $brand_sales_product): ?>
							<div class="tab-pane fade <?php if ($i == 0) echo 'active in' ?>" id="brand-<?= $id; ?>" >
                                <?php foreach($brand_sales_product as $single_product): ?>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
                                                <?php $mainImg = $single_product->getImage();   ?>
												<a href="<?=\yii\helpers\Url::to(['product/view', 'slug' => $single_product->slug]) ?>"><?= Html::img($mainImg->getUrl(), ['alt' => $single_product->name]) ?></a>
												<h2><?= Currency::getPrice($single_product['price'], true);?></h2>
												<p><a href="<?=\yii\helpers\Url::to(['product/view', 'slug' => $single_product->slug]) ?>"><?= $single_product['name']  ?></a></p>
												<a href="<?= \yii\helpers\Url::to(['cart/add', 'id' => $single_product->id]) ?>" data-id="<?= $single_product->id ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
											</div>

										</div>
									</div>
								</div>
                                <?php endforeach; ?>
							</div>
                            <?php $i++; ?>
                            <?php endforeach; ?>
						</div>
					</div><!--/category-tab-->



				</div>
			</div>
		</div>
	</section>