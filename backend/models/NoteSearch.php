<?php

namespace backend\models;

use phpDocumentor\Reflection\Types\Null_;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * @property  created_at
 */
class NoteSearch extends Note
{

    public function scenarios()
    {

        return Model::scenarios();
    }

    public function rules()
    {
        return [
            [['body', 'title', 'created_at', 'updated_at','tag'], 'string'],
            [['api_id', 'user_id', 'id'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = Note::find();

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
            ['like', 'body', $this->body],
            ['like', 'tag', $this->tag],
            ['like', 'title', $this->title],
            ['like', 'user_id', $this->user_id],
            ['like', 'api_id', $this->api_id],
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
}