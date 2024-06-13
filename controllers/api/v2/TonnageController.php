<?php
namespace app\controllers\api\v2;

use app\components\filters\TokenAuthMiddleware;
use app\services\TonnageService;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;

class TonnageController extends Controller
{
    public $enableCsrfValidation = false;
    private TonnageService $tonnageService;

    public function __construct($id, $module, TonnageService $tonnageService, $config = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->tonnageService = $tonnageService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'class' => TokenAuthMiddleware::class,
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => [
                        'get', 'post', 'delete'
                    ],
                ]
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
            case 'GET': {
                return $this->tonnageService->getAllTonnages();
            }

            case 'POST': {
                $tonnage = $request->post('tonnage');
                $this->tonnageService->addTonnage($tonnage);
                Yii::$app->response->setStatusCode(201, 'Tonnage added successfully');

                return ['message' => 'Tonnage added successfully'];
            }

            case 'DELETE': {
                $tonnage = $request->get('id');
                $this->tonnageService->deleteTonnage($tonnage);
                Yii::$app->response->setStatusCode(204, 'Tonnage deleted successfully');

                return ['message' => 'Tonnage deleted successfully'];
            }
        }

        return null;
    }
}