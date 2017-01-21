<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'Graphic Materials';
?>
<h1>Graphic Materials</h1>

<div class="graph-mat-container">
<h2>Banners</h2>
<?php $i = 0;?>
<div class="banners-block">
        <?php foreach ($banners as $banner):?>
        <div class="single-banner-block">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <?php $i++ ?>
                <h4><?=$banner->name ?></h4>

                <?= $form->field($banner, 'img')->fileInput(['class' => 'graphic-mat-img-btn'])->label(false) ?>

                <?php $mainImg = $banner->getImage();  ?>
                <div class="graphic-mat-img-disp">
                    <?= Html::img($mainImg->getUrl('200x')) ?>
                </div>

                <?= $form->field($banner, 'link')->textInput(['maxlength' => true]) ?>
                <?= Html::hiddenInput ('id', $banner->id) ?>

                <div class="form-group">
                    <?= Html::submitButton('Update', ['class' =>'btn btn-primary graph-update-item']) ?>
                </div>
                <div class="image-success-notice-block">
                    <p class="text-success image-success-notice">Banner was saved</p>
                </div>
            <?php ActiveForm::end(); ?>
            <?php if ($i !== count($banners)) echo '<hr>'?>
        </div>
        <?php endforeach ?>
</div>
<h2 class="galleries-block-title">Galleries</h2>

<?php foreach ($galleries_names as $galleries_name):?>

    <div class="grahic-gallery-block" data-id="<?=$galleries_name->id?>">
        <div class="grahic-gallery-block-slides">
            <h4><?=$galleries_name->name ?></h4>


            <?php $i = 0; $j = 0; ?>
            <?php foreach ($gallery_items as $gallery_item):?>

                <?php if ($gallery_item->gallery_id == $galleries_name->id):?>
                    <div class="grahic-gallery-slide-block">
                    <?php $i++; ?>
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                        <p class="slide-number">Slide <?=$i?></p>

                        <?= $form->field($banner, 'link')->textInput(['maxlength' => true]) ?>
                        <?= Html::hiddenInput ('id', $gallery_item->id) ?>
                        <?php $mainImg = $gallery_item->getImage();  ?>
                        <div class="graphic-mat-img-disp">
                            <?= Html::img($mainImg->getUrl('200x')) ?>
                        </div>

                        <div class="form-group gallery-submit-group">
                            <?= Html::submitButton('Update', ['class' =>'btn btn-primary slide-submit graph-update-item']) ?>
                        </div>
                        <?= $form->field($gallery_item, 'img')->fileInput(['class' => 'graphic-mat-img-btn'])->label(false) ?>
                        <?= Html::button('Delete Slide', ['class' =>'btn btn-danger delete-slide', 'data-id' => $gallery_item->id]) ?>
                        <div class="clearfix"></div>
                        <div class="image-success-notice-block">
                            <p class="text-success image-success-notice">Slide was saved</p>
                        </div>
                    <?php ActiveForm::end(); ?>

                    </div>

                    <div class="clearfix"></div>

                    <hr>
                <?php endif ?>
            <?php endforeach ?>
        </div>
        <?=Html::button('Add New Slide <i class="fa fa-plus-square-o" aria-hidden="true"></i>', ['class' => 'add-slide-btn btn btn-success ']);?>
    </div>

<?php endforeach ?>
</div>
