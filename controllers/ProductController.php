<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;

class ProductController extends AppController {

    public function actionView($id) {
//        $id = Yii::$app->request->get('id');
        $product = Product::findOne($id);  // lazy loading
        if (empty($product)) {
            throw new \yii\web\HttpException(404, 'The requested Product could not be found.');
        }
//        $product = Product::find()->with('category')->where(['id' => $id])->limit(1)->one();  // greedy loading
        $hits = Product::find()->where(['hit' => '1'])->limit(5)->all();
        $this->setMeta('E-SHOPEER | '.$product->name, $product->keywords, $product->description );
        return $this->render('view', compact('product', 'hits'));
    }

}