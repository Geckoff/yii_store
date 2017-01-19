<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use Yii;

class AppAdminController extends Controller {


    /* Visibility update */

    public function actionVisUpdate($id, $vis) {
        $newvis = $vis ? 0 : 1;
        $model = $this->findModel($id);
        $model->active = $newvis;
        $model->save();
        $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetVisChecked() {
        $selection = Yii::$app->request->post('selection');
        $this->setCheckedVisibility($selection, 1);
    }

    public function actionSetUnvisChecked() {
        $selection = Yii::$app->request->post('selection');
        $this->setCheckedVisibility($selection, 0);
    }

    protected function setCheckedVisibility($selection, $vis) {
        $model = $this->returnModel()->where(['in', 'id', $selection])->all();               
        foreach ($model as &$item) {
            $item->active = $vis;
            $item->save();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /* Set Item order */

    public function actionSetArrowOrder($updown, $cur_order, $id, $cat_id) {
        $cur_item = $this->findModel($id);
        if ($updown == 'up') {
            $neigh_pos = $this->returnModel()->where(['category_id' => $cat_id])->andWhere(['<', 'order', $cur_order])->max('`order`');
            $neigh_item = $this->returnModel()->where(['order' => $neigh_pos])->andWhere(['category_id' => $cat_id])->one();
            $neigh_item->order = $neigh_pos + 1;
        }
        if ($updown == 'down') {
            $neigh_pos = $this->returnModel()->where(['category_id' => $cat_id])->andWhere(['>', 'order', $cur_order])->min('`order`');
            $neigh_item = $this->returnModel()->where(['order' => $neigh_pos])->andWhere(['category_id' => $cat_id])->one();
            $neigh_item->order = $neigh_pos - 1;
        }
        $neigh_item->save();
        $cur_item->order = $neigh_pos;
        $cur_item->save();
        $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSetCertainOrder() {
        if (!Yii::$app->request->isAjax) return false;
        $set_order = Yii::$app->request->post('order');

        if (!preg_match("/\d+/i", $set_order)) return false;
        $cur_order = Yii::$app->request->post('cur_order');
        $cat_id = Yii::$app->request->post('cat_id');
        $id = Yii::$app->request->post('id');
        $min_order = $this->returnModel()->where(['category_id' => $cat_id])->min('`order`');
        $max_order = $this->returnModel()->where(['category_id' => $cat_id])->max('`order`');
        if ($set_order == $cur_order) return $this->redirect(Yii::$app->request->referrer);
        $replacing_item = $this->findModel($id);
        if (!$this->returnModel()->where(['order' => $set_order])->andWhere(['category_id' => $cat_id])->one() && $set_order < $max_order && $set_order > $min_order) {
            $replacing_item->order = $set_order;
            $replacing_item->save();
        }
        else {
            if ($set_order > $max_order) $set_order = $max_order;
            if ($set_order < $min_order) $set_order = $min_order;
            $replacing_item->order = $set_order;
            $replacing_item->save();
            if ($set_order > $cur_order) {
                $models_change_order = $this->returnModel()->where(['category_id' => $cat_id])->andWhere(['>', 'order', $cur_order])->andWhere(['<=', 'order', $set_order])->andWhere(['<>', 'id', $id])->all();
                foreach ($models_change_order as &$item) {
                    $item->order = $item->order - 1;
                    $item->save();
                }
            }
            if ($set_order < $cur_order) {
                $models_change_order = $this->returnModel()->where(['category_id' => $cat_id])->andWhere(['<', 'order', $cur_order])->andWhere(['>=', 'order', $set_order])->andWhere(['<>', 'id', $id])->all();
                foreach ($models_change_order as &$item) {
                    $item->order = $item->order + 1;
                    $item->save();
                }
            }
        }
    }



}