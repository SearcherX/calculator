<?php

namespace app\models;

use app\models\History;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * @property int $id
 * @property string $raw_type
 * @property User $user
 * @property string $month
 * @property int $tonnage
 * @property int $price
 * @property string $table_data
 * @property string $created_at
 */
class HistorySearch extends History
{
    public static function tableName()
    {
        return 'histories';
    }

    public function rules()
    {
        return [
            [['created_at'], 'date', 'format' => 'd.m.Y'],
            [['tonnage'], 'integer'],
            [['month', 'raw_type'], 'safe'],
        ];
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function search($params)
    {
        $canViewHistory = Yii::$app->user->can('viewHistory');
        $query = $canViewHistory ? History::find() : History::find()->where(['user_id' => Yii::$app->user->identity->getId()]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

//         load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query
            ->andFilterWhere(['like', 'tonnage', $this->tonnage])
            ->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'raw_type', $this->raw_type])
            ->andFilterWhere(
                [
                    '=',
                    new Expression('DATE_FORMAT(created_at, "%d.%m.%Y")'),
                    date('d.m.Y', strtotime($this->created_at)),
                ]
            );

        return $dataProvider;
    }
}