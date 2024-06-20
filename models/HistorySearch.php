<?php

namespace app\models;

use app\models\History;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * @property int $id
 * @property string $raw_type
 * @property string $month
 * @property int $tonnage
 * @property int $price
 * @property string $table_data
 * @property string $created_at
 */
class HistorySearch extends History
{
    public $username;
    public $email;

    public function rules()
    {
        return [
            [['tonnage', 'price'], 'integer'],
            [['username', 'email', 'month', 'raw_type', 'created_at'], 'safe'],
        ];
    }

    public function search($params)
    {
        $canViewHistory = Yii::$app->user->can('viewHistory');
        $query = $canViewHistory ? History::find(): History::find()->where(['user_id' => Yii::$app->user->identity->getId()]);
        $query->joinWith('user');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'username' => [
                    'asc' => ['user.username' => SORT_ASC],
                    'desc' => ['user.username' => SORT_DESC],
                    'label' => 'Имя пользователя'
                ],
                'email' => [
                    'asc' => ['user.email' => SORT_ASC],
                    'desc' => ['user.email' => SORT_DESC],
                    'label' => 'Емейл'
                ],
                'raw_type',
                'month',
                'tonnage',
                'price',
                'created_at'
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'user.email', $this->email])
            ->andFilterWhere(['like', 'tonnage', $this->tonnage])
            ->andFilterWhere(['like', 'month', $this->month])
            ->andFilterWhere(['like', 'raw_type', $this->raw_type])
            ->andFilterWhere(['like', 'price', $this->price]);

        if (empty($this->created_at) === false) {
            $query->andFilterWhere(
                [
                    'LIKE',
                    'DATE(histories.created_at)',
                    $this->created_at
                ]
            );
        }

        return $dataProvider;
    }
}