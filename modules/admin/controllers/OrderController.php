<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Order;
use app\modules\admin\models\OrderItems;
use app\modules\admin\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\helpers\Currency;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends AppAdminController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST', 'GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $sort = Yii::$app->request->get('sort') ? Yii::$app->request->get('sort') : 'no-sort';
        if ($q = Yii::$app->request->get('q')) {
            $query = Order::find()->where(['like', 'name', $q]);
        }
        else $query = Order::find();

        $dataProvider = new ActiveDataProvider([     // data selected from the table that is sent into view in a specific object to be formated in certain way
            'query' => $query ,
            'pagination' => [
                'pageSize' => 20
            ],
            'sort' => [
                'defaultOrder' => [
                    'status' => SORT_ASC,
                    'updated_at' => SORT_DESC,

                ]
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'sort' => $sort
        ]);
    }

    /**
     * Displays a single Order model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        if (($model = Order::find()->where(['id' => $id])->with('orderItems')->one()) == null) throw new NotFoundHttpException('The requested page does not exist.');
        $product_ids = [];
        foreach ($model->orderItems as $item) {
            $product_ids[] = $item->product_id;
        }

        if ($model->status == 0) {
            $model->status = '1';
            $model->save();
            return $this->refresh();
        }

        $currency = new Currency();
        $currencies_rates = $currency->getCurencyRates();
        $products = Product::find()->select(['{{product}}.*',  '([[price]] * '.$currencies_rates['EUR'].') AS euros', '([[price]] * '.$currencies_rates['GBP'].') AS pounds'])->where(['id' => $product_ids])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Order #{$model->id} is updated.");
            return $this->refresh();
        } else {
            // Composing list of prices in different currencies
            $currency_set = Yii::$app->params['currency'];

            foreach ($currency_set as $currency_acr => $currency_info) {
                if ($currency_acr == $model->currency) {
                    $prim_currency = $currency_acr;
                    $prim_currency_sign = $currency_info[0];
                }
            }

            if ($prim_currency !== 'USD') {
                $usd_price = 0;
                foreach ($model->orderItems as $order_item) {
                    foreach ($products as $product) {
                        if ($order_item->product_id == $product->id) {
                            $usd_price += $product->price * $order_item->qty_item;
                        }
                    }
                }
            }
            else $usd_price = $model->sum;

            $currency = [];
            $currency[0]['sign'] = $prim_currency_sign;
            $currency[0]['value'] = $model->sum;

            $i = 1;
            foreach ($currency_set as $currency_acr => $currency_info) {
                if ($currency_acr == $prim_currency) continue;
                if ($currency_acr == 'USD') {
                    $currency[$i]['sign'] = $currency_info[0];
                    $currency[$i]['value'] = $usd_price;
                }
                else {
                    $current_sum = round(Currency::getRate($currency_acr) * $usd_price, 2);
                    $currency[$i]['sign'] = $currency_info[0];
                    $currency[$i]['value'] = $current_sum;
                }
                $i++;
            }

            return $this->render('update', [
                'model' => $model,
                'products' => $products,
                'currency' => $currency
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteCheck() {
        $selection = Yii::$app->request->post('selection');
        Order::deleteAll(['in', 'id', $selection]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
