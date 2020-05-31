<?php

namespace common\models;

use backend\models\Note;
use common\models\query\BlogQuery;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $short_description
 * @property string $img_path
 * @property int $user_id
 *
 * @property User $user
 * @property BlogAttachment[] $blogAttachments
 * @property BlogComment[] $blogComments
 * @property Note[] $notes
 */
class Blog extends \yii\db\ActiveRecord
{
    public $image;
    public $attachment;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    public static function find()
    {
        return new BlogQuery(get_called_class());
    }


    public function behaviors()
    {
        return [
            [
                'class' => UploadBehavior::class,
                'attribute' => 'attachment',
                'multiple' => true,
                'uploadRelation' => 'blogAttachments',
                'pathAttribute' => 'attachment_path',
                'baseUrlAttribute' => 'attachment_base_url'
            ],
            [
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
            ]
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['description', 'image_path'], 'string'],
            [['title', 'short_description'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['image_path', 'image_base_url'], 'string'],
            [['image', 'attachment'], 'safe'],
            ['title', 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'short_description' => 'Short Description',
            'img_path' => 'Img Path',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogAttachments()
    {
        return $this->hasMany(BlogAttachment::className(), ['blog_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogComments()
    {
        return $this->hasMany(BlogComment::className(), ['blog_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotes()
    {
        return $this->hasMany(Note::className(), ['blog_id' => 'id']);
    }


    public function getImage($default = null)
    {
        return $this->image_path
            ? \Yii::getAlias($this->image_base_url . $this->image_path)
            : $default;
    }

    public static function getMappedBlogs()
    {
        $blogs = self::find()->all();
        return  ArrayHelper::map($blogs, 'id', 'title');
    }

}
