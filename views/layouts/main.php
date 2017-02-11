<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\ClientAsset;
use app\assets\ltAppAsset;
use app\components\Parameters;

AppAsset::register($this);
ClientAsset::register($this);
ltAppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">              
</head><!--/head-->

<body>

<?php $this->beginBody() ?>
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-xs-7">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i>&nbsp;<?= Parameters::getParam('phone') ?></a></li>
								<li><a href="#"><i class="fa fa-envelope"></i>&nbsp;<?= Parameters::getParam('email') ?></a></li>
							</ul>
						</div>
					</div>
					<div class="col-xs-5">
						<div class="social-icons pull-right">
							<ul>
                                <?php $soc_nets = Parameters::getParam('soc_nets'); ?>
                                <li><a href="<?=$soc_nets['facebook']['value'] ?>"><i class="fa fa-facebook"></i></a></li>
								<li><a href="<?=$soc_nets['twitter']['value'] ?>"><i class="fa fa-twitter"></i></a></li>
								<li><a href="<?=$soc_nets['google_plus']['value'] ?>"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->

		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-xs-7 fix-hz">
						<div class="logo pull-left">
							<a href="<?=\yii\helpers\Url::home() ?>"><?=Html::img('@web/images/home/logo.png', ['alt' => 'Random Stuff']) ?></a>
						</div>
						<div class="btn-group currency-group">
                            <p><i class="fa fa-cog fa-spin fa-3x fa-fw"></i></p>
                            <?php
                                $cookies = Yii::$app->request->cookies;
                                $currency_name = $cookies->getValue('currency_name', 'USD');
                            ?>
                            <select id='currency' class='selectpicker store-picker currency-picker' name="currency" id="">
                                <?php foreach (Yii::$app->params['currency'] as $name => $value): ?>
                                    <option <?php if ($currency_name == $name) echo 'selected'; ?> value="<?=$name ?>"><?=$value[1] ?></option>
                                <?php endforeach; ?>
                            </select>
						</div>
					</div>
					<div class="col-xs-5">
						<div class="shop-menu pull-right">
							<ul class="pull-left">
								<li class="cart-button"><a href="#" onclick="return getCart()"><i class="fa fa-shopping-cart"></i> Cart</a></li>
							</ul>
                            <div class="search_box pull-right">
                                <form method="get" action="<?= \yii\helpers\Url::to(['category/search']) ?>">
                                    <input type="text" placeholder="Search" <?php if (isset($this->params['search_request'])) echo 'value="'.$this->params['search_request'].'"'?> name='q'/>
                                    <button type="submit"></button>
                                </form>
    						</div>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->

		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle-store navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="/" <?php if ($_SERVER['REQUEST_URI'] == '/') echo 'class="active"' ?> >Home</a></li>
								<li class="dropdown">

                                    <a href="#dropdown-menu-collapse"   data-toggle="collapse" aria-controls="dropdown-menu-collapse"  aria-expanded="false" <?php if (Yii::$app->controller->id == 'brand') echo 'class="active"'?>>Brands<i class="fa fa-angle-down"></i></a>
                                    <ul  class="sub-menu">
                                        <?php if (Yii::$app->controller->id == 'brand'):?>
                                            <?= \app\components\BrandsWidget::widget(['type' => 'barelist', 'id' => $this->params['brand_id']]) ?>
                                        <?php else: ?>
                                            <?= \app\components\BrandsWidget::widget(['type' => 'barelist']) ?>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <?= \app\components\MenuBuilderWidget::widget(['type' => 'header']) ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->

    <?=$content ?>

	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
                            <div class="footer-logo">
                                <?=Html::img('@web/images/home/logo.png', ['alt' => 'Random Stuff']) ?>
                            </div>
							<p>This is not a real online store. Just a test version of Yii2 based system.</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
                            <div class="single-widget my-widget">
    							<ul class="nav nav-pills nav-stacked footer-menu">
                                    <?= \app\components\MenuBuilderWidget::widget(['type' => 'footer']) ?>
    							</ul>
    						</div>
						</div>
                        <div class="col-sm-9">
                            <div class="single-widget free-call">
                                <h4>Free call</h4>
    							<p><?= Parameters::getParam('phone') ?></p>
    						</div>
						</div>
                    </div>
					<div class="col-sm-3">
						<div class="address">
							<?=Html::img('@web/images/home/map.png', ['alt' => 'map']) ?>
							<p>1563 Wellington Ct., Loveland, CO</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left footer-copyright">Copyright © 2017 Andrei Hetsevich. All rights reserved.</p>
					<p class="pull-right"><?=Html::img('@web/images/home/fpro.png', ['alt' => 'fpro.by']) ?>  </p>
				</div>
			</div>
		</div>

	</footer><!--/Footer-->

    <?php
    \yii\bootstrap\Modal::begin([
        'header' => '<h2>Cart</h2>',
        'id' => 'cart',
        'size' => 'modal-lg',
        'footer' => '<a href="'.\yii\helpers\Url::to(['cart/view']).'" type="button" class="btn btn-default proceed shop-button">Proceed to checkout</a>
                     <button type="button" class="btn btn-default delete-all shop-button" onclick="clearCart()">Delete all items</button>'
    ]);

    \yii\bootstrap\Modal::end();
    ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>