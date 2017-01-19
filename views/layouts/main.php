<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\ltAppAsset;
use app\components\Parameters;

AppAsset::register($this);
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
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i><?= Parameters::getParam('phone') ?></a></li>
								<li><a href="#"><i class="fa fa-envelope"></i><?= Parameters::getParam('email') ?></a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
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
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="<?=\yii\helpers\Url::home() ?>"><?=Html::img('@web/images/home/logo.png', ['alt' => 'E-shopper']) ?></a>
						</div>
						<div class="btn-group pull-right">
                            <?php
                                $cookies = Yii::$app->request->cookies;
                                $currency_name = $cookies->getValue('currency_name', 'USD');
                            ?>
                            <select id='currency'  name="currency" id="">
                                <?php foreach (Yii::$app->params['currency'] as $name => $value): ?>
                                    <option <?php if ($currency_name == $name) echo 'selected'; ?> value="<?=$name ?>"><?=$value[1] ?></option>
                                <?php endforeach; ?>
                            </select>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
                                <!--<?php if (!Yii::$app->user->isGuest): ?>
								<li><a href="<?= \yii\helpers\Url::to(['/site/logout']) ?>"><i class="fa fa-user"></i> <?= Yii::$app->user->identity['username'] ?> (Exit)</a></li>
                                <?php endif; ?>-->
								<li><a href="#" onclick="return getCart()"><i class="fa fa-shopping-cart"></i> Cart</a></li>
								<!--<li><a href="<?= \yii\helpers\Url::to(['/admin']) ?>"><i class="fa fa-lock"></i> Login</a></li> -->
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->

		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.html" class="active">Home</a></li>
								<li class="dropdown"><a href="#">Brands<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <?= \app\components\BrandsWidget::widget(['type' => 'barelist']) ?> 
                                    </ul>
                                </li>
                                <?= \app\components\MenuBuilderWidget::widget(['type' => 'header']) ?>
								<!--<li><a href="404.html">Shipping</a></li>
								<li><a href="404.html">Returns</a></li>
								<li><a href="404.html">About Us</a></li>
								<li><a href="contact-us.html">Contact</a></li>-->
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
                            <form method="get" action="<?= \yii\helpers\Url::to(['category/search']) ?>">
                                <input type="text" placeholder="Search" name='q'/>
                            </form>
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
							<h2><span>e</span>-shopper</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
                            <div class="single-widget my-widget">
    							<ul class="nav nav-pills nav-stacked">
                                    <?= \app\components\MenuBuilderWidget::widget(['type' => 'footer']) ?>
    								<!--<li><a href="#">Shipping</a></li>
    								<li><a href="#">Return</a></li>
    								<li><a href="#">About Us</a></li>
    								<li><a href="#">Contacts</a></li>-->
    							</ul>
    						</div>
						</div>
                        <div class="col-sm-9">
                            <div class="single-widget free-call">
                                <h4>Free call:</h4>
    							<p><?= Parameters::getParam('phone') ?></p>
    						</div>
						</div>
                    </div>
					<div class="col-sm-3">
						<div class="address">
							<img src="images/home/map.png" alt="" />
							<p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
					<p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
				</div>
			</div>
		</div>

	</footer><!--/Footer-->

    <?php
    \yii\bootstrap\Modal::begin([
        'header' => '<h2>Cart</h2>',
        'id' => 'cart',
        'size' => 'modal-lg',
        'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Continue Shopping</button>
                     <a href="'.\yii\helpers\Url::to(['cart/view']).'" type="button" class="btn btn-success">Proceed to checkout</a>
                     <button type="button" class="btn btn-danger" onclick="clearCart()">Delete all items</button>'
    ]);

    \yii\bootstrap\Modal::end();
    ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>