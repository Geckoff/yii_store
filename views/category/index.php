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
							<div class="item active">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Free E-Commerce Template</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
									<img src="/images/home/girl1.jpg" class="girl img-responsive" alt="" />
									<img src="/images/home/pricing.png"  class="pricing" alt="" />
								</div>
							</div>
							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>100% Responsive Design</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
									<img src="/images/home/girl2.jpg" class="girl img-responsive" alt="" />
									<img src="/images/home/pricing.png"  class="pricing" alt="" />
								</div>
							</div>

							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Free Ecommerce Template</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
									<img src="/images/home/girl3.jpg" class="girl img-responsive" alt="" />
									<img src="/images/home/pricing.png" class="pricing" alt="" />
								</div>
							</div>

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
												<?= Html::img($mainImg->getUrl(), ['alt' => $single_product->name]) ?>
												<h2><?= Currency::getPrice($single_product['price'], true);?></h2>
												<p><a href="<?=\yii\helpers\Url::to(['product/view', 'id' => $single_product->id]) ?>"><?= $single_product['name']  ?></a></p>
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