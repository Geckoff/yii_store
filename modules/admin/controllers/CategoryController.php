<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Category;
use app\modules\admin\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends AppAdminController
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $sort = Yii::$app->request->get('sort') ? Yii::$app->request->get('sort') : 'no-sort';
        if ($q = Yii::$app->request->get('q')) {
            $query = Category::find()->with('category')->where(['like', 'name', $q]);  // greedy select
        }
        else $query = Category::find()->with('category');  // greedy select

        $dataProvider = new ActiveDataProvider([
            'query' => $query,   // greedy select
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'sort' => $sort
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post())) {
            $max_order = Category::find()->where(['parent_id' => $model->parent_id])->max('`order`');
            $order = $max_order ? $max_order + 1 : 1;
            $model->order = $order;
            $model->save();
            Yii::$app->session->setFlash('success', "Category {$model->name} is added");
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Category {$model->name} is updated.");
            return $this->refresh();
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (Product::find()->where(['category_id' => $id])->all()){
            Yii::$app->session->setFlash('error', "Category contains products and can not be deleted.");
            return $this->redirect(Yii::$app->request->referrer);
        }
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDeleteCheck() {
        $selection = Yii::$app->request->post('selection');
        if (Product::find()->where(['in', 'id', $selection])->all()){
            Yii::$app->session->setFlash('error', "Categories contain products and can not be deleted.");
            return $this->redirect(Yii::$app->request->referrer);
        }
        Category::deleteAll(['in', 'id', $selection]);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function returnModel() {
        return Category::find();
    }

    /* Changing order of categories in menu */

    public function actionMenuOrder() {
        if (!Yii::$app->request->isAjax) return false;
        $prim_id = Yii::$app->request->post('prim_id');
        $prim_order = Yii::$app->request->post('prim_order');
        $sec_id = Yii::$app->request->post('sec_id');
        $sec_order = Yii::$app->request->post('sec_order');

        $prim_model = $this->findModel($prim_id);
        $sec_model = $this->findModel($sec_id);

        $prim_model->order = $sec_order;
        $sec_model->order = $prim_order;

        if ($prim_model->save() && $sec_model->save()) return true;
        else return false;
    }
}
