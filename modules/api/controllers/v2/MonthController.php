<?php

namespace app\modules\api\controllers\v2;

use app\components\filters\TokenAuthMiddleware;
use app\services\MonthService;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class MonthController extends Controller
{
    public $enableCsrfValidation = false;
    private MonthService $monthService;

    public function __construct($id, $module, MonthService $monthService, $config = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->monthService = $monthService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => TokenAuthMiddleware::class
            ],
            'corsFilter' => [
                'class' => Cors::class
            ],
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => [
                        'get', 'post', 'delete', 'options'
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;

        switch ($request->method) {
            case 'GET':
            {
                return $this->monthService->getAllMonths();
            }

            case 'POST':
            {
                $month = $request->post('month');
                $this->monthService->addMonth($month);
                Yii::$app->response->setStatusCode(201, 'Month added successfully');

                return ['message' => 'Month added successfully'];
            }

            case 'DELETE':
            {
                $month = $request->get('id');
                $this->monthService->deleteMonth($month);
                Yii::$app->response->setStatusCode(204, 'Month deleted successfully');

                return ['message' => 'Month deleted successfully'];
            }
        }

        return null;
    }
}