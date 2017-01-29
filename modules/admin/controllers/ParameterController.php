<?php

namespace app\modules\admin\controllers;
use app\modules\admin\models\Parameter;
use yii\helpers\Html;
use yii\base\DynamicModel;
use Yii;

class ParameterController extends \yii\web\Controller
{

    /**
    * Displaying options page
    **/
    public function actionIndex()
    {
        $options = [];
        $model = Parameter::find()->all();
        foreach ($model as $option) {
            if ($unser_val = unserialize($option['value'])) $options[$option['name']]['value'] = $unser_val;
            else $options[$option['name']]['value'] = $option['value'];
            $options[$option['name']]['title'] = $option['title'];
            $options[$option['name']]['type'] = $option['type'];
        }
        return $this->render('index', [
            'options' => $options
        ]);
    }

    /**
    * Updating parameter
    **/
    public function actionUpdate()
    {
        if ($data = Yii::$app->request->post()) {
            $save = true;
            foreach ($data as $option => $param_arr) {
                if ($option == '_csrf') continue;              // skipping csrf check parameter
                elseif (is_array($param_arr['value'])) {       // for parameters that should be serialized
                    foreach ($param_arr['value'] as $nested_option => $nested_param_arr) {
                        if ($nested_param_arr['type']) {
                            if (!$this->validateParam($nested_param_arr['value'], $nested_param_arr['type'], $nested_param_arr['title'])) $save = false;
                        }
                    }
                    if ($save) $this->saveParameter($option, $param_arr['value'], true);
                }
                else {      // for not serialized parameters
                    if ($param_arr['type']) {
                        if ($this->validateParam($param_arr['value'], $param_arr['type'], $param_arr['title'])) {
                            $this->saveParameter($option, $param_arr['value'], false);
                        }
                        else $save = false;
                    }
                }
            }
            if ($save) Yii::$app->session->setFlash('success', 'All options have been saved');
            $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
    * Validating parameter.
    * Type of parameter is set in `type` field of `parameter` table
    **/
    private function validateParam($value, $type, $option) {
        $model = DynamicModel::validateData(['check_value' => $value], [
            ['check_value', $type]
        ]);
        if ($model->hasErrors()) {
            Yii::$app->session->setFlash('error', $option.' should be '.$type.' format');
            return false;
        }
        else return true;
    }


    /**
    * Saving parameter
    **/
    private function saveParameter($option, $param_arr_value, $serialize) {
        $model = Parameter::find()->where(['name' => $option])->one();
        if ($serialize) $model->value = serialize($param_arr_value);
        else $model->value = $param_arr_value;
        $model->save();
    }

}
