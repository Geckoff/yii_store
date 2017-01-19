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
	<header id="header"><!--header-->




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
								<li><a href="<?= Url::to(['/admin'])  ?>" class="active">Home</a></li>
								<li class="dropdown"><a href="#">Categories<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="<?= Url::to(['category/index'])  ?>">Category List</a></li>
										<li><a href="<?= Url::to(['category/create'])  ?>">Add Cateory</a></li>
                                    </ul>
                                </li>
								<li class="dropdown"><a href="#">Products<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="<?= Url::to(['product/index'])  ?>">Product List</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?= Url::to(['brand/index'])  ?>" class="active">Brands</a></li>
                                <li><a href="<?= Url::to(['post/index'])  ?>" class="active">Posts</a></li>
                                <li><a href="<?= Url::to(['parameter/index'])  ?>" class="active">Options</a></li>
                                <li><a href="<?= Url::to(['graphic/update'])  ?>" class="active">Graphic Materials</a></li>
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

	<footer id="footer"><!--Footer-->


	</footer><!--/Footer-->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>