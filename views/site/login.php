<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login-table">
<div class="site-login">
<div class="site-login-inner">

    <?= Html::img('@web/images/home/fpro-login.png', ['alt'=>'fpro']);?>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal admin-login-form'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-login-error\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-12 pull-left control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe', ['options' => ['class' => 'form-group col-xs-9']])->checkbox([
            'template' => "<div class=\"col-xs-12\">{input} {label}</div>\n",
        ]) ?>

        <div class="form-group submit-group">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
</div>
