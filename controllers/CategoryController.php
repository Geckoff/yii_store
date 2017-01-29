<?php

namespace app\controllers;

use app\models\Category;
use app\models\Brand;
use app\models\Product;
use app\helpers\Currency;
use Yii;
use yii\data\Pagination;
use \yii\db\Query;

class CategoryController extends AppController {

    /**
    * Main page of the website
    **/
    public function actionIndex() {

        $sales_brands = Brand::find()->where(['sales' => '1'])->asArray()->all();
        $sales_brands_ids = [];
        foreach ($sales_brands as $sales_brand) {
            $sales_brands_ids[] = $sales_brand['id'];
        }
        $sales_products = Product::find()->where(['brand_id' => $sales_brands_ids])->andWhere(['active' => '1'])->all();
        $brand_sales_products = [];
        foreach($sales_brands_ids as $sales_brands_id) {
            foreach($sales_products as $sales_product) {
                if ($sales_brands_id == $sales_product->brand_id  && count($brand_sales_products[$sales_brands_id]) < 4 ) {
                    $brand_sales_products[$sales_brands_id][] = $sales_product;
                }
            }
        }

        $hits = Product::find()->where(['hit' => '1'])->andWhere(['active' => '1'])->limit(6)->all();
        $this->setMeta('E-SHOPPER');
        return $this->render('index', compact('hits', 'brand_sales_products', 'sales_brands', 'sales_products'));
    }

    /**
    * Composing Category Catalog page
    **/
    public function actionView() {       // we can get id either from the url
        $slug = Yii::$app->request->get('slug');      // or from get array
        $category = Category::find()->where(['slug' => $slug])->one();
        $gets = [];
        if (empty($category)) {
            throw new \yii\web\HttpException(404, 'The requested Category could not be found.');
        }
        /** $query = Product::find()->select(['{{product}}.*',  '([[rating]] / [[voters]]) AS final_rating'])->where(['category_id' => $category->id]);
        * with query above Pagination is not working as well as $query->count() if sorting by final_rating field is used (error is that query is not an object).
        * however if sorting is made by other fields everything is working fine. need to figure out why.
        */
        $query = Product::find()->where(['category_id' => $category->id])->andWhere(['active' => '1']);
        if (Yii::$app->request->get('min') && Yii::$app->request->get('max')) {      // price range parameters were enabled
            $gets['min'] = Yii::$app->request->get('min');
            $gets['max'] = Yii::$app->request->get('max');
            $min = Currency::getDollarPrice(Yii::$app->request->get('min'));
            $max = Currency::getDollarPrice(Yii::$app->request->get('max'));

            $query = $query->andWhere(['between','price', $min, $max]);
        }
        if ($sort = Yii::$app->request->get('sort')) {
            if ($sort == 'ascp') $query = $query->orderBy(['price' => SORT_ASC]);    // filter parameters were enabled
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
        else {
            $query = $query->orderBy(['order' => SORT_ASC]);
        }

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);

        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        $this->setMeta('E-SHOPEER | '.$category->name, $category->keywords, $category->description );
        if ($ajax = Yii::$app->request->isAjax) {       // Price Range slider was used for filtering
            $this->layout = false;
            return $this->render('range', compact('products', 'pages', 'category', 'gets'));
        }
        return $this->render('view', compact('products', 'pages', 'category', 'gets'));
    }

    /**
    * Search Category Catalog page
    **/
    public function actionSearch() {
        $q = (Yii::$app->request->get('q'));
        $this->setMeta('E-SHOPEER | Search: '.$q);
        if (!$q) {
            return $this->render('search');
        }
        $gets = []; 
        $query = Product::find()->where(['like', 'name', $q]);
        if (Yii::$app->request->get('min') && Yii::$app->request->get('max')) {      // price range parameters were enabled
            $gets['min'] = Yii::$app->request->get('min');
            $gets['max'] = Yii::$app->request->get('max');
            $min = Currency::getDollarPrice(Yii::$app->request->get('min'));
            $max = Currency::getDollarPrice(Yii::$app->request->get('max'));

            $query = $query->andWhere(['between','price', $min, $max]);
        }
        if ($sort = Yii::$app->request->get('sort')) {
            if ($sort == 'ascp') $query = $query->orderBy(['price' => SORT_ASC]);    // filter parameters were enabled
            if ($sort == 'descp') $query = $query->orderBy(['price' => SORT_DESC]);
            if ($sort == 'asca') $query = $query->orderBy(['name' => SORT_ASC]);
            if ($sort == 'desca') $query = $query->orderBy(['name' => SORT_DESC]);
            if ($sort == 'pop') $query = $query->orderBy(['voters' => SORT_DESC]);
            if ($sort == 'rate') $query = $query->orderBy(['current_rating' => SORT_DESC]);
            $gets['sort'] = $sort;
        }
        elseif (Yii::$app->request->get('min') && Yii::$app->request->get('max')) {
            $query = $query->orderBy(['price' => SORT_ASC]);
        }
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        if (Yii::$app->request->isAjax) {                  // Price Range slider was used for filtering 
            $this->layout = false;
            return $this->render('range', compact('products', 'pages', 'q', 'gets'));
        }
        return $this->render('search', compact('products', 'pages', 'q', 'gets'));
    }



}