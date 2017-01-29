<?php

namespace app\controllers;

use app\models\Post;
use app\helpers\Currency;
use app\models\ContactForm;
use app\components\Parameters;
use Yii;

class PostController extends AppController {

    /* Displaying the post */
    public function actionView() {
        $slug = Yii::$app->request->get('slug');
        $post = Post::find()->where(['slug' => $slug])->one();
        if (empty($post)) {
            throw new \yii\web\HttpException(404, 'Page not found.');
        }

        /* Unique layout for Contacts page */
        if ($slug == 'contacts') {
            $model = new ContactForm();
            if ($model->load(Yii::$app->request->post()) && $model->contact(Parameters::getParam('email'))) {
                Yii::$app->session->setFlash('success', 'Your message was sent.');
                return $this->refresh();
            }
            return $this->render('contacts', compact('post', 'model'));
        }

        return $this->render('view', compact('post'));
    }

}