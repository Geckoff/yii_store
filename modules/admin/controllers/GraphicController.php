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
            //debug(Yii::$app->request->post());
            $model = Graphic::findOne($id);
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $model->img = UploadedFile::getInstance($model, 'img');
                if ($model->img) {
                    $model->upload();
                }
                unset($model->img);
            }
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

}
