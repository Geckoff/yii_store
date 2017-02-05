<?php
use yii\helpers\Html;
use app\helpers\Currency;

$product = $this->product;
?>
<div class="col-sm-4">
			<div class="product-image-wrapper">
				<div class="single-products">
					<div class="productinfo text-center">
                        <?php $mainImg = $product->getImage();  ?>
						<a href="<?=\yii\helpers\Url::to(['product/view', 'slug' => $product->slug]) ?>"><?= Html::img($mainImg->getUrl('480x480'), ['alt' => $product->name]) ?></a>
						<h2><?= Currency::getPrice($product->price, true);?></h2>
                        <div class="item-product-name-wrap">
                            <div class="item-product-name">
                                <p>
                                    <a href="<?=\yii\helpers\Url::to(['product/view', 'slug' => $product->slug]) ?>"><?= $product->name; ?></a>
                                </p>
                            </div>
                        </div>
						<a href="#" data-id="<?=$product->id ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>

					</div>
					<div class="product-overlay">
            			<div class="overlay-content">
                            <div class="product-overl-name">
                                <p><a href="<?=\yii\helpers\Url::to(['product/view', 'slug' => $product->slug]) ?>"><?= $product->name; ?></a></p>
                            </div>
                            <div class="product-overl-desc"><?= $product->content; ?></div>
            				<h2><?= Currency::getPrice($product->price, true);?></h2>
            				<a href="<?= \yii\helpers\Url::to(['cart/add', 'id' => $product->id]) ?>" data-id="<?= $product->id ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
            				<a href="<?=\yii\helpers\Url::to(['product/view', 'slug' => $product->slug]) ?>" class="btn btn-default add-to-cart">Details...</a>
            			</div>
            		</div>
                    <?php if($product->new): ?>
                        <?= Html::img("@web/images/home/new.png", ['alt' => 'new', 'class' => 'new']) ?>
                    <?php endif; ?>
                    <?php if($product->sale): ?>
                        <?= Html::img("@web/images/home/sale.png", ['alt' => 'discount', 'class' => 'new']) ?>
                    <?php endif; ?>
				</div>
                <div class="card-rating">
                    <?php $rating = ($product->rating > 0 && $product->voters > 0) ? round($product->rating/$product->voters, 1) : 'No' ?>
                    <div class="rating-data" data-cur="<?= $rating ?>"></div>
                    <select class="example-fontawesome-o" >
                        <option value=""></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                    <?php
                    if ($product->voters == 1) $votes = '1 vote';
                    elseif ($product->voters > 1) $votes = $product->voters.' votes';
                    else $votes = '<span class="votes-0">No votes</span>';
                    ?>
                    <p><?= $votes ?></p>
                </div>
			</div>
		</div>