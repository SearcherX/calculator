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
        $price = null;
        $raw_typePrices = null;
        $headTableTM = null;

        if($form_model->load(\Yii::$app->request->post())){
            if (!$form_model->validate()) {
                // данные не корректны: $errors - массив содержащий сообщения об ошибках
                $errors = $form_model->errors;
                return $this->render('index', compact(
                    'form_model',
                    'monthsList',
                    'tonnagesList',
                    'raw_typesList'
                ));
            }
            $raw_typePrices = $prices[$form_model->raw_type];
            $price = $raw_typePrices[$form_model->month][$form_model->tonnage];
            $headTableTM = getPriceTonnages($form_model->raw_type, $prices);
        }

        $bodyTableTM = $raw_typePrices;

        return $this->render('index', compact(
            'form_model',
            'monthsList',
            'tonnagesList',
            'raw_typesList',
            'price',
            'headTableTM',
            'bodyTableTM')
        );
    }

    public function actionCalculator()
    {
        global $lists, $prices;
        $form_model = new CalculatorForm();
        $monthsList = getDropDownArray($lists['months']);
        $tonnagesList = getDropDownArray($lists['tonnages']);
        $raw_typesList = getDropDownArray($lists['raw_types']);

        if (empty(Yii::$app->request->post()) === false) {
            $basePath = Yii::getAlias('@runtime') . '/queue.job';

            if (file_exists($basePath)) {
                unlink($basePath);
            }

            foreach (Yii::$app->request->post()['CalculatorForm'] as $key => $value) {
                file_put_contents($basePath, "$key = $value", FILE_APPEND);
            }
        }

        return $this->render('calculator', compact(
            'form_model',
            'monthsList',
            'tonnagesList',
            'raw_typesList'
        ));
    }

}