<?php

namespace app\controllers;

use app\helpers\DAOMapper;
use app\helpers\RenderHelper;
use app\helpers\Utils;
use app\models\CalculatorForm;
use app\models\History;
use app\services\MonthService;
use app\services\PriceService;
use app\services\TonnageService;
use app\services\TypeService;
use Dotenv\Dotenv;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CalculatorController extends Controller
{
    private MonthService $monthService;
    private TonnageService $tonnageService;
    private TypeService $typeService;
    private PriceService $priceService;

    /**
     * @param $id
     * @param $module
     * @param MonthService $monthService
     * @param TonnageService $tonnageService
     * @param TypeService $typeService
     * @param PriceService $priceService
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        MonthService $monthService,
        TonnageService $tonnageService,
        TypeService $typeService,
        PriceService $priceService,
        $config = []
    )
    {
        $this->monthService = $monthService;
        $this->tonnageService = $tonnageService;
        $this->typeService = $typeService;
        $this->priceService = $priceService;
        parent::__construct($id, $module, $config);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $dotenv = Dotenv::createImmutable(Yii::getAlias("@app"));
        $dotenv->load();

        if ($_ENV['RENDER_MODE'] === 'SPA') {
            return require_once \Yii::getAlias("@app/web/index.html");
        }

        $formModel = new CalculatorForm();
        $monthsList = RenderHelper::getDropDownArray($this->monthService->getAllMonths());
        $tonnagesList = RenderHelper::getDropDownArray($this->tonnageService->getAllTonnages());
        $typesList = RenderHelper::getDropDownArray($this->typeService->getAllTypes());

        if ($formModel->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            try {
                $price = $this->priceService->getByMonthAndTonnageAndType(
                    $formModel->month,
                    $formModel->tonnage,
                    $formModel->raw_type
                );
                $prices = $this->priceService->getPriceByType($formModel->raw_type);
            } catch (NotFoundHttpException $e) {
                return $this->renderAjax('error', [
                    'message' => $e->getMessage()
                ]);
            }

            if (Yii::$app->user->isGuest === false) {
                $history = new History();
                $history->snapshot($formModel, $price, $prices);
            };

            $dataProvider = new ArrayDataProvider([
                'allModels' => $prices,
                'pagination' => false
            ]);

            return $this->renderAjax('result', [
                'model' => $formModel,
                'price' => $price,
                'dataProvider' => $dataProvider
            ]);
        }

        return $this->render('calculator', [
            'model' => $formModel,
            'months' => $monthsList,
            'tonnages' => $tonnagesList,
            'types' => $typesList
        ]);
    }

    public function actionValidate()
    {
        $model = new CalculatorForm();

        if (Yii::$app->request->isAjax) {
            if (empty(Yii::$app->request->post()) === false) {
                $model->load(Yii::$app->request->post());
            }

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        return null;
    }

}