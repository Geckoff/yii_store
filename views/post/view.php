<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
?>
	<section>
		<div class="container">
			<div class="row">
				<?= \app\components\LeftSideBarWidget::widget() ?>
				<div class="col-sm-9 padding-right">
                    <h2 class="cat-h2 title text-center"><?=$post->name ?></h2>
                    <div class="post-text">
                        <?=$post->text ?>
                    </div>
				</div>
			</div>
		</div>
	</section>