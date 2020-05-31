<?php
namespace frontend\models;
use yii\db\ActiveRecord;

class myUsers extends ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%myUsers}}';
    }

    public function rules(){
        return [
            ['id', 'unique']
        ];
    }
}