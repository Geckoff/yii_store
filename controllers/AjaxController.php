<?php
namespace app\controllers;
use app\models\Category;
use app\models\Brand;
use app\models\Product;
use app\helpers\Currency;
use yii\data\Pagination;
use Yii;

class AjaxController extends AppController {

    protected function saveCookieCurrency($currency) {
        $data = file_get_contents("http://api.fixer.io/latest?base=USD&symbols=".$currency);
        $data = json_decode($data, true);
        $rate = $data['rates'][$currency];
        if (!$rate) $rate = 1;
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new \yii\web\Cookie([
            'name' => 'currency_name',
            'value' => $currency,
        ]));
        $cookies->add(new \yii\web\Cookie([
            'name' => 'currency_rate',
            'value' => $rate,
        ]));

        return $rate;
    }

    public function actionCurrencyRate() {
        $currency = Yii::$app->request->get('currency');
        $this->saveCookieCurrency($currency);
    }

    public function actionRange() {

        $min = Currency::getDollarPrice(Yii::$app->request->get('min'));
        $max = Currency::getDollarPrice(Yii::$app->request->get('max'));
        $gets = [];
        $gets['min'] = $min;
        $gets['max'] = $max;
        $query = Product::find()->orderBy(['price' => SORT_ASC])->where(['between','price', $min, $max]);
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
        $items = $query->offset($pages->offset)->limit($pages->limit)->all();
        if (Yii::$app->request->isAjax) {
            $this->layout = false;
            return $this->render('range', compact('items', 'pages', 'gets'));
        }
        return $this->render('rangeview', compact('items', 'pages', 'gets'));
    }

    public function actionConvertCurrency() {
        $min = Currency::getDollarPrice(Yii::$app->request->get('min'));
        $max = Currency::getDollarPrice(Yii::$app->request->get('max'));
        $currency = Yii::$app->request->get('currency');
        $rate = $this->saveCookieCurrency($currency);
        $min = round($min * $rate);
        $max = round($max * $rate);
        return json_encode(['min' => $min, 'max' => $max, 'rate' => $rate]);
    }

}