<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class BlogSearch extends Blog
{

    public function scenarios()
    {

        return Model::scenarios();
    }

    public function rules()
    {
        return [
            [['description', 'title', 'created_at', 'updated_at'], 'string'],
            [['user_id', 'id'], 'integer'],
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Blog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 4],
        ]);
        $this->load($params);


        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'and',
            ['like', 'title', $this->title],
            ['like', 'user_id', $this->user_id],
            ['like', 'id', $this->id]
        ]);

        if ($this->created_at) {
            $query
                ->andWhere("FROM_UNIXTIME(created_at, '%Y-%m-%d') = FROM_UNIXTIME(:createdAt, '%Y-%m-%d')")
                ->addParams([
                    ':createdAt' => strtotime($this->created_at)
                ]);
        }

        if ($this->updated_at) {
            $query
                ->andWhere("FROM_UNIXTIME(updated_at, '%Y-%m-%d') = FROM_UNIXTIME(:updatedAt, '%Y-%m-%d')")
                ->addParams([
                    ':updatedAt' => strtotime($this->updated_at)
                ]);
        }

        return $dataProvider;
    }

    public static function getPaginationIndex(&$index, $userId)
    {
        if ($userId === null) {
            $models = self::find()->all();
        } else {
            $models = self::find()->where(["user_id" => $userId])->all();
        }
        if ($index < 0) {
            $index = 0;
        }

        if ($index + 1 > intval(sizeof($models) / 2) + intval(sizeof($models) % 2)) {
            $index = intval(sizeof($models) / 2) + intval(sizeof($models) % 2) - 1;
        }
        return $models;
    }
}