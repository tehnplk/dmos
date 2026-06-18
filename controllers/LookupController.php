<?php

namespace app\controllers;

use yii\web\Controller;
use yii\helpers\ArrayHelper;
use app\components\MyLookUp;

/**
 * PatientHosController implements the CRUD actions for PatientHos model.
 */
class LookupController extends Controller {

    public function actionTmbList() {

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $amp = $parents[0];
                $tmbs = \app\models\Ctmb::find()
                        ->where(['amp' => $amp])
                        ->select(['code as id', 'name'])
                        ->asArray()
                        ->all();

                return json_encode(['output' => $tmbs, 'selected' => '']);
            }
        }
        return json_encode(['output' => '', 'selected' => '']);
    }

    public function actionMooList() {

        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $tmb = $parents[0];
                $moos = \app\models\Cmoo::find()
                        ->where(['tmb' => $tmb])
                        ->select(["code AS id", "CONCAT(RIGHT(code,2), '-', name) AS name"])
                        ->asArray()
                        ->all();

                return json_encode(['output' => $moos, 'selected' => '']);
            }
        }
        return json_encode(['output' => '', 'selected' => '']);
    }

}
