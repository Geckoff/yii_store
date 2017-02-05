<?php

namespace app\controllers;

use app\models\Brand;
use app\models\Product;
use app\models\Graphic;
use app\helpers\Currency;
use Yii;
use yii\data\Pagination;

class BrandController extends AppController {

    /* Composing Brand Catalog page */

    public function actionView() {
        $slug = Yii::$app->request->get('slug');
        $brand = Brand::find()->where(['slug' => $slug])->one();
        $this->view->params['brand_id'] = $brand->id;  // making param available in layout view
        $gets = [];
        if (empty($brand)) {
            throw new \yii\web\HttpException(404, 'The requested Brand could not be found.');
        }
        $query = Product::find()->where(['brand_id' => $brand->id])->andWhere(['active' => '1']);

        if (Yii::$app->request->get('min') && Yii::$app->request->get('max')) {      // price range parameters were enabled
            $gets['min'] = Yii::$app->request->get('min');
            $gets['max'] = Yii::$app->request->get('max');
            $min = Currency::getDollarPrice(Yii::$app->request->get('min'));
            $max = Currency::getDollarPrice(Yii::$app->request->get('max'));

            $query = $query->andWhere(['between','price', $min, $max]);
        }
        if ($sort = Yii::$app->request->get('sort')) {                                // filter parameters were enabled
            if ($sort == 'ascp') $query = $query->orderBy(['price' => SORT_ASC]);
            if ($sort == 'descp') $query = $query->orderBy(['price' => SORT_DESC]);
            if ($sort == 'asca') $query = $query->orderBy(['name' => SORT_ASC]);
            if ($sort == 'desca') $query = $query->orderBy(['name' => SORT_DESC]);
            if ($sort == 'pop') $query = $query->orderBy(['voters' => SORT_DESC]);
            if ($sort == 'rate') $query = $query->orderBy(['current_rating' => SORT_DESC]);
            $gets['sort'] = $sort;
        }
        elseif (Yii::$app->request->get('min') || Yii::$app->request->get('max')) {
            $query = $query->orderBy(['price' => SORT_ASC]);
        }

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();

        $this->setMeta('E-SHOPEER | '.$brand->name, $brand->keywords, $brand->description );
        if ($ajax = Yii::$app->request->isAjax) {          // Price Range slider was used for filtering
            $this->layout = false;
            return $this->render('range', compact('products', 'pages', 'brand', 'gets'));
        }
        $banner = Graphic::findOne(7);
        return $this->render('view', compact('products', 'pages', 'brand', 'gets', 'banner'));
    }

}