<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<h1>Graphic Materials</h1>


<h2>Banners</h2>
<?php foreach ($banners as $banner):?>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <h4><?=$banner->name ?></h4>

        <?= $form->field($banner, 'img')->fileInput()->label(false) ?>

        <?php $mainImg = $banner->getImage();  ?>
        <?= Html::img($mainImg->getUrl('200x')) ?>


        <?= $form->field($banner, 'link')->textInput(['maxlength' => true]) ?>
        <?= Html::hiddenInput ('id', $banner->id) ?>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' =>'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>
    <hr>
<?php endforeach ?>
<hr>
<h2>Galleries</h2>

<?php foreach ($galleries_names as $galleries_name):?>

    <h4><?=$galleries_name->name ?></h4>



    <?php foreach ($gallery_items as $gallery_item):?>

        <?php if ($gallery_item->gallery_id == $galleries_name->id):?>

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <p><?=$gallery_item->name ?></p>

                <?= $form->field($gallery_item, 'img')->fileInput()->label(false) ?>
                <?= Html::hiddenInput ('id', $gallery_item->id) ?>
                <?php $mainImg = $gallery_item->getImage();  ?>
                <?= Html::img($mainImg->getUrl('200x')) ?>

                <div class="form-group">
                    <?= Html::submitButton('Update', ['class' =>'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>

        <?php endif ?>

    <?php endforeach ?>


<?php endforeach ?>

