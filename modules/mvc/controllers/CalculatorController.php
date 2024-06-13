<?php

namespace app\modules\mvc\controllers;

use app\helpers\Utils;
use app\models\CalculatorForm;
use Yii;
use yii\web\Controller;

class CalculatorController extends Controller
{
    public function actionIndex()
    {
        $form_model = new CalculatorForm();
        $monthsList = Utils::getDropDownArray(Yii::$app->params['lists']['months']);
        $tonnagesList = Utils::getDropDownArray(Yii::$app->params['lists']['tonnages']);
        $raw_typesList = Utils::getDropDownArray(Yii::$app->params['lists']['raw_types']);
        $price = null;
        $raw_typePrices = null;
        $headTableTM = null;
        $prices = Yii::$app->params['prices'];

        if (empty(Yii::$app->request->post()) === false) {
            $basePath = Yii::getAlias('@runtime') . '/queue.job';

            foreach (Yii::$app->request->post()['CalculatorForm'] as $key => $value) {
                file_put_contents($basePath, "$key => $value" . PHP_EOL, FILE_APPEND);
            }

            file_put_contents($basePath, "..." . PHP_EOL, FILE_APPEND);
        }

        if($form_model->load(\Yii::$app->request->post())){
            if (!$form_model->validate()) {
                return $this->render('index', compact(
                    'form_model',
                    'monthsList',
                    'tonnagesList',
                    'raw_typesList'
                ));
            }
            $raw_typePrices = $prices[$form_model->raw_type];
            $price = $raw_typePrices[$form_model->month][$form_model->tonnage];
            $headTableTM = Utils::getPriceTonnages($form_model->raw_type, $prices);
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

}