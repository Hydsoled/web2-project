<?php

namespace common\models;

use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "blog_attachment".
 *
 * @property int $id
 * @property string $attachment_path
 * @property int $blog_id
 *
 * @property Blog $blog
 */
class BlogAttachment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog_attachment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['blog_id', 'required'],
            ['blog_id', 'integer'],
            [['attachment_path', 'attachment_base_url'], 'string'],
            [['blog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blog::className(), 'targetAttribute' => ['blog_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attachment_path' => 'Attachment Path',
            'blog_id' => 'Blog ID',
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
     * {@inheritdoc}
     * @return bool|string
     */


    public function getAttachment($default = null)
    {
        return $this->attachment_path
            ? \Yii::getAlias($this->attachment_base_url . $this->attachment_path)
            : $default;
    }
}
