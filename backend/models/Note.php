<?php

namespace backend\models;

use common\behaviors\ArrayToStringBehavior;
use common\models\Blog;
use common\models\User;
use trntv\filekit\behaviors\UploadBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Html;

class Note extends ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => 'user_id'
            ],
            'arrayToString' => [
                'class' => ArrayToStringBehavior::class,
                'attrs' => 'tag',
                'delimiter' => ','
            ]
        ];

    }

    public static function tableName()
    {
        return 'note';
    }

    public function rules()
    {
        return [
            [['title', 'body'], 'required'],
            ['tag', 'each', 'rule' => ['string']],
            [['title', 'body'], 'string', 'length' => [5, 20]],
            [['user_id', 'api_id', 'created_at', 'updated_at','blog_id'], 'integer']
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getBlog()
    {
        return $this->hasOne(Blog::className(), ['id' => 'blog_id']);
    }
    /**
     * @description This method return bootstrap badges
     * @return string
     */
    public function getDisplayBadges()
    {
        if (!$this->tag) {
            return '';
        }
        $tags = $this->tag;

        $returnString = "";

        foreach ($tags as $tag) {
            $returnString .= Html::tag('span', $tag, [
                'class' => 'label label-success',
                'style' => 'margin-right: 3px'
            ]);
        }

        return $returnString;
    }
    public static function getSendUrl($url, $data){
        $fields_string = http_build_query($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return  json_decode($response);

    }
}