<?php

namespace app\controllers\api\v2;

use app\components\filters\TokenAuthMiddleware;
use app\services\DAOUtils;
use app\services\MonthDAO;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class MonthController extends Controller
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
            case 'GET':
            {
                $rows = MonthDAO::readAll();
                return DAOUtils::mapToString($rows, 'name');
            }

            case 'POST':
            {
                $month = $request->post('month');
                $isMonthExists = MonthDAO::read($month) !== false;

                if ($isMonthExists) {
                    throw new BadRequestHttpException('Месяц уже существует');
                }

                MonthDAO::add($month);
                Yii::$app->response->setStatusCode(201, 'Успешное добавление');
                Yii::$app->response->content = '';

                return;
            }

            case 'DELETE':
            {
                $month = $request->get('id');
                $isMonthExists = MonthDAO::read($month) !== false;

                if (!$isMonthExists) {
                    throw new NotFoundHttpException('Месяц не найден');
                }

                MonthDAO::remove($month);
                Yii::$app->response->setStatusCode(204, 'Успешное удаление');

                return ['message' => 'Успешное удаление'];
            }
        }

        return null;
    }
}