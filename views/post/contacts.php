<?php

/* @var $this yii\web\View */

use app\components\Parameters;
use yii\bootstrap\ActiveForm;
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
                        <p><b>Phone</b>: <?=Parameters::getParam('phone') ?></p>
                        <p><b>E-mail</b>: <?=Parameters::getParam('email') ?></p>

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

                        <h3>Send us a message</h3>

                        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                            <?= $form->field($model, 'email') ?>

                            <?= $form->field($model, 'subject') ?>

                            <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

                            <div class="form-group">
                                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                            </div>

                        <?php ActiveForm::end(); ?>
                    </div>
				</div>
			</div>
		</div>
	</section>