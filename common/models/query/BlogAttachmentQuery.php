<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\BlogAttachment]].
 *
 * @see \common\models\BlogAttachment
 */
class BlogAttachmentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\BlogAttachment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\BlogAttachment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
