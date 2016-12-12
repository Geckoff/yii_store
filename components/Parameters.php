<?php

namespace app\components;

use app\models\Parameter;
use Yii;

class Parameters {

    public static function getParam($param) {
        $param = Parameter::find()->where(['name' => $param])->one();
        if (empty($param)) return 'Empty Parameter';

        $data = @unserialize($param->value);
        if (!$data) return $param->value;

        return $data;
    }

}