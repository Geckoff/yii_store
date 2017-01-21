<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Graphic;
use app\modules\admin\models\Carousel;
use Yii;
use yii\web\UploadedFile;

class GraphicController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdate()
    {
        if ($id = Yii::$app->request->post('id')){
            debug(Yii::$app->request->post());
            $model = Graphic::findOne($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $model->img = UploadedFile::getInstance($model, 'img');
                if ($model->img) {
                    $model->upload();
                }
                unset($model->img);
            }
            return $this->refresh();
        }
        else {
            $banners = Graphic::find()->where(['gallery' => '0'])->all();
            $gallery_items = Graphic::find()->where(['gallery' => '1'])->all();
            $galleries_names = Carousel::find()->all();

            return $this->render('update', [
                'banners' => $banners,
                'gallery_items' => $gallery_items,
                'galleries_names' => $galleries_names,
            ]);
        }
    }

    public function actionUpdateSlide() {
        if (Yii::$app->request->isAjax) {
            if ($id = Yii::$app->request->post('id')){
                $model = Graphic::findOne($id);
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    $model->img = UploadedFile::getInstance($model, 'img');
                    if ($model->img) {
                        $model->upload();
                    }
                    unset($model->img);
                }
                echo 'suc';
            }
        }
    }

    public function actionNewSlide() {
        if (Yii::$app->request->isAjax) {
            if (Yii::$app->request->post()){
                $model = new Graphic();
                if ($model->load(Yii::$app->request->post())) {
                    $model->gallery = 1;
                    $model->gallery_id = Yii::$app->request->post('gallery_id');
                    $model->save();
                    $model->img = UploadedFile::getInstance($model, 'img');
                    if ($model->img) {
                        $model->upload();
                    }
                    unset($model->img);
                }
                echo $model->id;
            }
        }
    }

    public function actionDelete() {
        if (Yii::$app->request->isAjax) {
            if (Yii::$app->request->post()){
                $id = Yii::$app->request->post('id');
                Graphic::findOne($id)->delete();
            }
        }
    }

}
