<?php
namespace app\controllers\api\v2;

use app\components\filters\TokenAuthMiddleware;
use app\services\TypeService;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\Response;

class TypeController extends Controller
{
    public $enableCsrfValidation = false;
    private TypeService $typeService;

    public function __construct($id, $module, TypeService $typeService, $config = [])
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->typeService = $typeService;
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
                return $this->typeService->getAllTypes();
            }

            case 'POST': {
                $type = $request->post('type');
                $this->typeService->addType($type);
                Yii::$app->response->setStatusCode(201, 'Raw type added successfully');

                return ['message' => 'Raw type added successfully'];
            }

            case 'DELETE': {
                $type = $request->get('id');
                $this->typeService->removeType($type);
                Yii::$app->response->setStatusCode(204, 'Raw type deleted successfully');

                return ['message' => 'Raw type deleted successfully'];
            }
        }

        return null;
    }
}