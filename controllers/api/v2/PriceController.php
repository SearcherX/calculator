<?php

namespace app\controllers\api\v2;

use app\components\filters\TokenAuthMiddleware;
use app\services\DAOUtils;
use app\services\MonthDAO;
use app\services\PriceDAO;
use app\services\TonnageDAO;
use app\services\TypeDAO;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

$projectRoot = Yii::getAlias('@app');
include_once $projectRoot . "/utils/utils.php";

class PriceController extends Controller
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
                        'get', 'post', 'delete', 'patch'
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
                $month = $request->get('month');
                $type = $request->get('type');
                $tonnage = $request->get('tonnage');

                $monthRecord = MonthDAO::read($month);
                $typeRecord = TypeDAO::read($type);
                $tonnageRecord = TonnageDAO::read($tonnage);

                if ($monthRecord === false || $tonnageRecord === false || $typeRecord === false) {
                    throw new NotFoundHttpException('Стоимость для выбранных параметров отсутствует');
                }

                $priceRecord = PriceDAO::read($monthRecord['id'], $typeRecord['id'], $tonnageRecord['id']);
                $rows = PriceDAO::readAll($typeRecord['id']);

                return [
                    'price' => $priceRecord['price'],
                    'price_list' => [
                        $type => DAOUtils::getTable($rows)
                    ]
                ];
            }

            case 'POST':
            {
                $month = $request->post('month');
                $type = $request->post('type');
                $tonnage = $request->post('tonnage');
                $price = $request->post('price');

                $monthRecord = MonthDAO::read($month);
                $typeRecord = TypeDAO::read($type);
                $tonnageRecord = TonnageDAO::read($tonnage);

                PriceDAO::add($price, $monthRecord['id'], $tonnageRecord['id'], $typeRecord['id']);
                Yii::$app->response->setStatusCode(201, 'Успешное добавление');

                return ['message' => 'Успешное добавление'];
            }

            case 'PATCH':
            {
                $type = $request->get('type');
                $tonnage = $request->get('tonnage');
                $month = $request->get('month');
                $price = $request->post('price');

                $monthRecord = MonthDAO::read($month);
                $typeRecord = TypeDAO::read($type);
                $tonnageRecord = TonnageDAO::read($tonnage);

                if ($monthRecord === false || $tonnageRecord === false || $typeRecord === false) {
                    throw new NotFoundHttpException('Стоимость для выбранных параметров отсутствует');
                }

                $priceRecord = PriceDAO::read($monthRecord['id'], $typeRecord['id'], $tonnageRecord['id']);

                if ($priceRecord === false) {
                    throw new NotFoundHttpException('Стоимость для выбранных параметров отсутствует');
                }

                PriceDAO::update($price, $monthRecord['id'], $tonnageRecord['id'], $typeRecord['id']);

                return ['message' => 'Успешное обновление'];
            }

            case 'DELETE':
            {
                $type = $request->get('type');
                $tonnage = $request->get('tonnage');
                $month = $request->get('month');

                $monthRecord = MonthDAO::read($month);
                $typeRecord = TypeDAO::read($type);
                $tonnageRecord = TonnageDAO::read($tonnage);

                if ($monthRecord === false || $tonnageRecord === false || $typeRecord === false) {
                    throw new NotFoundHttpException('Стоимость для выбранных параметров отсутствует');
                }

                $priceRecord = PriceDAO::read($monthRecord['id'], $typeRecord['id'], $tonnageRecord['id']);

                if ($priceRecord === false) {
                    throw new NotFoundHttpException('Стоимость для выбранных параметров отсутствует');
                }

                PriceDAO::remove($monthRecord['id'], $tonnageRecord['id'], $typeRecord['id']);
                Yii::$app->response->setStatusCode(204, 'Успешное удаление');

                return ['message' => 'Успешное удаление'];
            }
        }

        return null;
    }
}