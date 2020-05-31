<?php

namespace common\models;

use common\models\query\BlogCommentQuery;
use DateTime;
use DateTimeZone;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "blog_comment".
 *
 * @property int $id
 * @property string $comment
 * @property int $blog_id
 * @property int $user_id
 *
 * @property Blog $blog
 * @property User $user
 */
class BlogComment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog_comment';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ]
            ],
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => 'user_id'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['blog_id', 'comment'], 'required'],
            [['blog_id', 'user_id', 'created_at'], 'integer'],
            [['comment'], 'string', 'max' => 2000],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blog::className(), 'targetAttribute' => ['blog_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comment' => 'Comment',
            'blog_id' => 'Blog ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlog()
    {
        return $this->hasOne(Blog::className(), ['id' => 'blog_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\BlogCommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogCommentQuery(get_called_class());
    }
}
