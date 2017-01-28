<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\assets\ltAppAsset;

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
    <title>Admin Dashboard | <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body class="admin-dash">
<?php $this->beginBody() ?>
	<header class="admin-header"><!--header-->
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
            			<ul class="admin-mainmenu nav navbar-nav collapse navbar-collapse">
            				<li><a href="<?= Url::to(['/admin'])  ?>" <?php if (Yii::$app->controller->id == 'order') echo 'class="active"'?>>Orders</a></li>
                                <li><a href="<?= Url::to(['category/index'])  ?>" <?php if (Yii::$app->controller->id == 'category') echo 'class="active"'?>>Categories</a></li>
                                <li><a href="<?= Url::to(['product/index'])  ?>" <?php if (Yii::$app->controller->id == 'product') echo 'class="active"'?>>Products</a></li>
                                <li><a href="<?= Url::to(['brand/index'])  ?>" <?php if (Yii::$app->controller->id == 'brand') echo 'class="active"'?>>Brands</a></li>
                                <li><a href="<?= Url::to(['post/index'])  ?>" <?php if (Yii::$app->controller->id == 'post') echo 'class="active"'?>>Posts</a></li>
                                <li><a href="<?= Url::to(['parameter/index'])  ?>" <?php if (Yii::$app->controller->id == 'parameter') echo 'class="active"'?>>Options</a></li>
                                <li><a href="<?= Url::to(['graphic/update'])  ?>" <?php if (Yii::$app->controller->id == 'graphic') echo 'class="active"'?>>Graphic Materials</a></li>
                                <li class="admin-logout"><a href="<?= Url::to(['graphic/update'])  ?>"><i class="fa fa-power-off" aria-hidden="true"></i> Log Out</a></li>
            			</ul>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->

    <div class="container">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <?php echo Yii::$app->session->getFlash('success'); ?>
        </div>

        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo Yii::$app->session->getFlash('error'); ?>
            </div>
        <?php endif; ?>
	    <?=$content ?>
    </div>

	<footer id="admin-footer"><!--Footer-->
        <div class="copyright">
            <p>Project Factory &copy; 2013 - <?php echo date("Y"); ?></p>
        </div>

        <div class="logo">
            <?= Html::img('@web/upload/store/no-image.png', ['alt'=>'some', 'class'=>'thing']);?> 
        </div>

	</footer><!--/Footer-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>