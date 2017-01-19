<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends AppAdminController
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        if ($q = Yii::$app->request->get('q')) {
            $query = Post::find()->where(['like', 'name', $q])->orderBy('order');
        }
        else $query = Post::find()->orderBy('order');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $model = Post::find()->orderBy('order')->all() ;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post())) {
            $max_order = Post::find()->max('`order`');
            $model->order = $max_order++;
            $model->save();
            return $this->redirect(['update', 'id' => $model->id]);
        }
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Post {$model->name} is updated.");
            return $this->refresh();
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
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
        Post::deleteAll(['in', 'id', $selection]);
        $this->redirect(Yii::$app->request->referrer);
    }

    /* Post Order */

    public function actionPostOrder() {

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $posts_ids = json_decode($data['array']);

            for ($i = 0; $i < count($posts_ids); $i++) {
                $post = $this->findModel($posts_ids[$i]);
                $post->order = $i;
                $post->save();
            }
        }

    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function returnModel() {
        return Post::find();
    }
}
