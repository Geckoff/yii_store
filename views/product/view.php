<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use app\helpers\Currency;
?>

<section>
		<div class="container">
			<div class="row">
				<?= \app\components\LeftSideBarWidget::widget(['controller' => 'product', 'id' => ['brand_id' => $product->brand_id, 'category_id' => $product->category_id]]) ?>

<?php

    $mainImg = $product->getImage();
    $gallery = $product->getImages();

?>

				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
                            <div class="item-gallery">
                                <?= Html::img($mainImg->getUrl('360x360'), ['id' => 'img_01', 'data-zoom-image' => $mainImg->getUrl('900x900')]) ?>

                                <div id="gal1">

                                    <?php foreach ($gallery as $img): ?>
                                    <a href="#" data-image="<?=$img->getUrl('360x360') ?>" data-zoom-image="<?=$img->getUrl('900x900') ?>">
                                        <?= Html::img($img->getUrl('80x80'), ['id' => 'img_01', 'class' => 'zoomer-preview']) ?>
                                    </a>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
                                <?php if($product->new): ?>
                                    <?= Html::img("@web/images/home/new.png", ['alt' => 'new', 'class' => 'newarrival']) ?>
                                <?php endif; ?>
                                <?php if($product->sale): ?>
                                    <?= Html::img("@web/images/home/sale.png", ['alt' => 'discount', 'class' => 'newarrival']) ?>
                                <?php endif; ?>
								<h2><?= $product->name ?></h2>
								<p class="item-id">Item ID: <?= $product->id ?></p>
                                <?php $rating = ($product->rating > 0 && $product->voters > 0) ? round($product->rating/$product->voters, 1) : 'No votes' ?>
                                <div id="cur-rating" data-cur='<?= $rating ?>' data-id='<?= $product->id ?>'></div>
                                <div class="item-rating">
                                    <div class="rating-helper"></div>
                                    <select id="example-fontawesome-o" >
                                        <option value=""></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div id='display-rating-block'>
                                    <?php if ($rating == 'No votes') : ?>
                                    <p id='no-rating'><?= $rating ?></p>
                                    <?php else : ?>
                                    <p id='disp-rating-details'>Rating: <span id='rating-disp'><?= $rating ?></span> Voters: <span id='voters-disp'><?= $product->voters ?></span></p>
                                    <?php endif; ?>
                                </div>
								<span>
									<span><?= Currency::getPrice($product->price); ?></span>
									<label>Quantity:</label>
									<input type="text" value="1" id="qty" />
									<a href="<?= \yii\helpers\Url::to(['cart/add', 'id' => $product->id]) ?>" data-id="<?=$product->id ?>" class="btn btn-fefault add-to-cart cart">
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</a>
								</span>
								<p><b>Brand:</b><a href="<?= \yii\helpers\Url::to(['category/view', 'id' => $product->category->id]) ?>"> <?=$product->category->name ?></a></p>

                                <?= $product->content ?>
							</div><!--/product-information-->
						</div>
					</div>

                    <script>

                    </script>
					<div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">recommended items</h2>

						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
                                <?php $i = 0 ?>
                                <?php foreach ($hits as $hit): ?>
                                    <?php $mainImg = $hit->getImage();  ?>
                                    <?php if ($i % 3 == 0): ?>
    								<div class="item <?php if ($i == 0) echo 'active';  ?>">
                                    <?php endif; ?>
    									<div class="col-sm-4">
    										<div class="product-image-wrapper">
    											<div class="single-products">
    												<div class="productinfo text-center">
    													<?= Html::img($mainImg->getUrl(), ['alt' => $hit->name]) ?>
    													<h2><?= Currency::getPrice($hit->price, true); ?></h2>
    													<p><a href="<?= \yii\helpers\Url::to(['product/view', 'id' => $hit->id]) ?>"><?= $hit->name ?></a></p>
    													<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
    												</div>
    											</div>
    										</div>
    									</div>
                                        <?php $i++; ?>
                                    <?php if ($i % 3 == 0 || $i == count($hits)): ?>
    								</div>
                                    <?php endif; ?>

                                <?php endforeach; ?>
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>
						</div>
					</div><!--/recommended_items-->

				</div>
			</div>
		</div>
	</section>