<?php
namespace app\controllers\api\v2;

use app\components\filters\TokenAuthMiddleware;
use app\services\DAOUtils;
use app\services\TypeDAO;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TypeController extends Controller
{
    public $enableCsrfValidation = false;

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

        switch ($request->method) {
            case 'GET': {
                $rows = TypeDAO::readAll();

                return DAOUtils::mapToString($rows, 'name');
            }

            case 'POST': {
                $type = $request->post('type');
                $isTypeExists = TypeDAO::read($type) !== false;

                if ($isTypeExists) {
                    throw new BadRequestHttpException('Тип сырья уже существует');
                }

                TypeDAO::add($type);
                Yii::$app->response->setStatusCode(201, 'Успешное добавление');

                return ['message' => 'Успешное добавление'];
            }

            case 'DELETE': {
                $type = $request->get('id');
                $isTypeExists = TypeDAO::read($type) !== false;

                if (!$isTypeExists) {
                    throw new NotFoundHttpException('Тип сырья не найден');
                }

                TypeDAO::remove($type);
                Yii::$app->response->setStatusCode(204, 'Успешное удаление');

                return ['message' => 'Успешное удаление'];
            }
        }

        return null;
    }
}