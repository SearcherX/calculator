<?php
namespace app\controllers\api\v2;

use app\components\filters\TokenAuthMiddleware;
use app\services\DAOUtils;
use app\services\TonnageDAO;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TonnageController extends Controller
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
                $rows = TonnageDAO::readAll();

                return DAOUtils::mapToString($rows, 'value');
            }

            case 'POST': {
                $tonnage = $request->post('tonnage');
                $isTonnageExists = TonnageDAO::read($tonnage) !== false;

                if ($isTonnageExists) {
                    throw new BadRequestHttpException('Тоннаж уже существует');
                }

                TonnageDAO::add($tonnage);
                Yii::$app->response->setStatusCode(201, 'Успешное добавление');

                return ['message' => 'Успешное добавление'];
            }

            case 'DELETE': {
                $tonnage = $request->get('id');
                $isTonnageExists = TonnageDAO::read($tonnage) !== false;

                if (!$isTonnageExists) {
                    throw new NotFoundHttpException('Тоннаж не найден');
                }

                TonnageDAO::remove($tonnage);
                Yii::$app->response->setStatusCode(204, 'Успешное удаление');

                return ['message' => 'Успешное удаление'];
            }
        }

        return null;
    }
}