<?php

namespace app\controllers;

use app\models\CalculatorForm;
use Yii;
use yii\web\Controller;

const PROJECT_ROOT = __DIR__ . "/../";
include_once PROJECT_ROOT . "utils/utils.php";

global $lists, $prices;
$lists = require_once PROJECT_ROOT . "config/lists.php";
$prices = require_once PROJECT_ROOT . "config/prices.php";

class CalculatorController extends Controller
{
    public function actionIndex()
    {
        global $lists, $prices;
        $form_model = new CalculatorForm();
        $monthsList = getDropDownArray($lists['months']);
        $tonnagesList = getDropDownArray($lists['tonnages']);
        $raw_typesList = getDropDownArray($lists['raw_types']);

        if (empty(Yii::$app->request->post()) === false) {
            $basePath = Yii::getAlias('@runtime') . '/queue.job';

            foreach (Yii::$app->request->post()['CalculatorForm'] as $key => $value) {
                file_put_contents($basePath, "$key => $value" . PHP_EOL, FILE_APPEND);
            }

            file_put_contents($basePath, "..." . PHP_EOL, FILE_APPEND);
        }

        return $this->render('calculator', compact(
            'form_model',
            'monthsList',
            'tonnagesList',
            'raw_typesList'
        ));
    }

}