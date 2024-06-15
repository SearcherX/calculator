<?php

namespace app\modules\api\controllers\v2;

use app\components\filters\TokenAuthMiddleware;
use app\services\PriceService;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;

class PriceController extends Controller
{
    public $enableCsrfValidation = false;
    private PriceService $priceService;

    public function __construct($id, $module, PriceService $priceService, $config = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->priceService = $priceService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => TokenAuthMiddleware::class
            ],
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => [
                        'get', 'post', 'delete', 'patch', 'options'
                    ],
                ]
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::class
            ],
            'contentNegotiator' => [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;

        switch ($request->getMethod()) {
            case 'GET':
            {
                $month = $request->get('month');
                $type = $request->get('type');
                $tonnage = $request->get('tonnage');

                return [
                    'price' => $this->priceService->getByMonthAndTonnageAndType($month, $tonnage, $type),
                    'price_list' => [
                        $type => $this->priceService->getPriceByType($type)
                    ]
                ];
            }

            case 'POST':
            {
                $month = $request->post('month');
                $type = $request->post('type');
                $tonnage = $request->post('tonnage');
                $price = $request->post('price');
                $this->priceService->addPrice($month, $tonnage, $type, $price);
                Yii::$app->response->setStatusCode(201, 'Price added successfully');

                return ['message' => 'Price added successfully'];
            }

            case 'PATCH':
            {
                $type = $request->get('type');
                $tonnage = $request->get('tonnage');
                $month = $request->get('month');
                $price = $request->post('price');
                $this->priceService->updatePrice($month, $tonnage, $type, $price);

                return ['message' => 'Price updated successfully'];
            }

            case 'DELETE':
            {
                $type = $request->get('type');
                $tonnage = $request->get('tonnage');
                $month = $request->get('month');
                $this->priceService->deletePrice($month, $tonnage, $type);
                Yii::$app->response->setStatusCode(204, 'Price deleted successfully');

                return ['message' => 'Price deleted successfully'];
            }
        }

        return null;
    }
}