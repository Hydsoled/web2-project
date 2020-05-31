<?php

namespace frontend\models;

use common\behaviors\ArrayToStringBehavior;
use common\models\User;
use trntv\filekit\behaviors\UploadBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Html;

class Note extends ActiveRecord
{

    public $image;
    public function behaviors()
    {
        return [
            'image' => [
                'class' => UploadBehavior::class,
                'attribute' => 'image',
                'pathAttribute' => 'image_path',
                'baseUrlAttribute' => 'image_base_url'
            ],
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
            [['title', 'body', 'image'], 'required'],
            [['image_path', 'image_base_url'], 'string'],
            ['tag', 'each', 'rule' => ['string']],
            [['title', 'body'], 'string', 'length' => [5, 20]],
            [['user_id', 'api_id', 'created_at', 'updated_at'], 'integer'],
            ['image', 'safe']
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

//    public function getImage($default = null)
//    {
//        return $this->image_path
//            ? \Yii::getAlias($this->image_base_url . $this->image_path)
//            : $default;
//    }

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
}