<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;

class ProductController extends AppController {

    public function actionView($slug) {
        $product = Product::find()->where(['slug' => $slug])->one();  // lazy loading
        if (empty($product)) {
            throw new \yii\web\HttpException(404, 'The requested Product could not be found.');
        }
//        $product = Product::find()->with('category')->where(['id' => $id])->limit(1)->one();  // greedy loading
        $hits = Product::find()->where(['category_id' => $product->category_id])->limit(6)->orderBy('rating')->all();
        $this->setMeta('E-SHOPEER | '.$product->name, $product->keywords, $product->description );
        return $this->render('view', compact('product', 'hits'));
    }

    public function actionGetRating() {
        $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);
        $rating = round($product->rating / $product->voters, 1);
        return json_encode(['rating' => $rating, 'voters' => $product->voters]);
    }

    public function actionRate() {
        if (!Yii::$app->request->isAjax) {
            throw new \yii\web\HttpException(404, 'No ajax request');
        }

        $id = Yii::$app->request->get('id');
        $value = Yii::$app->request->get('value');

        $cookies = Yii::$app->request->cookies;

        if (isset($cookies['ratings'])) {
            $ratings = (substr_count($cookies['ratings'], '=') == 1) ? $ratings = [$cookies['ratings']] :  $ratings = explode(';', $cookies['ratings']);
            $isset_flag = false;
            $ratings_save = [];
            foreach ($ratings as $rating) {      // split to array [[id1, value1], [id2, value2], [id3, value3], ...]
                $rating = explode('=', $rating);
                if ($id == $rating[0]) {         // item was rated by user before
                    $voters_add = 0;
                    $value_add = $value - $rating[1];
                    $rating[1] = $value;
                    $isset_flag = true;
                }
                $ratings_save[] = $rating;
            }

            if (!$isset_flag) {                  // item was not rated by user before
                $ratings_save[] = [$id, $value];
                $voters_add = 1;
                $value_add = $value;
            }

            $ratings_save_temp = [];
            foreach ($ratings_save as $rating_save) {
                // combining to array [id1=value1, id2=value2, id3=value3, ...]
                $rating_save = implode('=', $rating_save);
                $ratings_save_temp[] = $rating_save;
            }

            $ratings_save = implode(';', $ratings_save_temp);   // combining to string id1=rating1;id2=rating2;id3=rating3;.....
        }
        else {
            $ratings_save = "$id=$value";
            $voters_add = 1;
            $value_add = $value;
        }

        if (strpos($ratings_save, '=;')) return true;           // prevent multiple hitting of star bar

        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'ratings',
            'value' => $ratings_save
        ]));


        $model = $this->findModel($id);
        $model->rating = $model->rating + $value_add;
        $model->voters = $model->voters + $voters_add;
        $model->current_rating =  round(($model->rating) / ($model->voters), 1);
        $model->save();
    }

    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}