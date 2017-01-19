<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Product;
use app\modules\admin\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use app\helpers\Currency;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends AppAdminController
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $currency = new Currency();
        $sort = Yii::$app->request->get('sort') ? Yii::$app->request->get('sort') : 'no-sort';
        $currencies_rates = $currency->getCurencyRates();
        $category_page = false;
        $order_param = 'id';
        if ($q = Yii::$app->request->get('q')) {
            $query = Product::find()->select(['{{product}}.*',  '([[price]] * '.$currencies_rates['EUR'].') AS euros', '([[price]] * '.$currencies_rates['GBP'].') AS pounds'])->where(['like', 'name', $q]);
        }
        elseif ($cat_id = Yii::$app->request->get('catid')) {
            $query = Product::find()->select(['{{product}}.*',  '([[price]] * '.$currencies_rates['EUR'].') AS euros', '([[price]] * '.$currencies_rates['GBP'].') AS pounds'])->where(['category_id' => $cat_id]);
            $category_page = Category::findOne($cat_id);
            $category_page = $category_page->name;
            $order_param = 'order';
        }
        else $query = Product::find()->select(['{{product}}.*',  '([[price]] * '.$currencies_rates['EUR'].') AS euros', '([[price]] * '.$currencies_rates['GBP'].') AS pounds']);

        if ($category_page) {
            $min_order = $query->min('`order`');
            $max_order = $query->max('`order`');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    $order_param => SORT_ASC,
                ]
            ]
        ]);                     
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'sort' => $sort,
            'category_page' => $category_page,
            'cat_id' => $cat_id,
            'min_order' => $min_order,
            'max_order' => $max_order
        ]);
    }

    /**
     * Displays a single Product model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        /*$model = $this->findModel($id)->getImages();
        foreach ($model as $img) echo $img->id;
       //debug($model);*/
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {
            $cat_id = Yii::$app->request->post("Product");
            $max_order = Product::find()->where(['category_id' => $cat_id['category_id']])->max('`order`');
            $model->order = $max_order + 1;
            if ($model->save()) {
                $model->image = UploadedFile::getInstance($model, 'image');
                if ($model->image) {
                    $model->upload();
                }
                unset($model->image);
                $model->gallery = UploadedFile::getInstances($model, 'gallery');
                $model->uploadGallery();

                Yii::$app->session->setFlash('success', "Product {$model->name} is added.");
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        else {
            $model->rating = 0;
            $model->voters = 0;
            $model->current_rating = 0;
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $cat_id = $model->category_id;

        if ($model->load(Yii::$app->request->post())) {
            $new_data = Yii::$app->request->post("Product");
            if ($cat_id !== $new_data['category_id']) {

                $max_order = Product::find()->where(['category_id' => $new_data['category_id']])->max('`order`');
                $model->order = $max_order + 1;
            }
            $model->save();
            $model->image = UploadedFile::getInstance($model, 'image');
            //debug($model->image);
            if ($model->image) {
                $model->upload();
            }
            unset($model->image);
            $model->gallery = UploadedFile::getInstances($model, 'gallery');
            $model->uploadGallery();

            Yii::$app->session->setFlash('success', "Product {$model->name} is updated.");
            return $this->refresh();
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $this->findModel($id)->delete();

        $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeleteCheck() {
        $selection = Yii::$app->request->post('selection');
        Product::deleteAll(['in', 'id', $selection]);
        $this->redirect(Yii::$app->request->referrer); 
    }

    public function actionDeleteImage() {
        if (Yii::$app->request->isAjax) {
            $img_id = (int)Yii::$app->request->post('img_id');
            $item_id = Yii::$app->request->post('item_id');

            $model = $this->findModel($item_id);

            $gallery = $model->getImages();

            $test = [];
            foreach($gallery as $gal_img) {

                if ($gal_img->id == $img_id) {
                    //return json_encode([$gal_img->id]);
                    $model->removeImage($gal_img);
                    break;
                }
            }
        }
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    protected function returnModel() {
        return Product::find();
    }

    protected function findModel($id)
    {
        $currency = new Currency();
        $currencies_rates = $currency->getCurencyRates();
        if (($model = Product::find()->select(['{{product}}.*',  '([[price]] * '.$currencies_rates['EUR'].') AS euros', '([[price]] * '.$currencies_rates['GBP'].') AS pounds'])->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
