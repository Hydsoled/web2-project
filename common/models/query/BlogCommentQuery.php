<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\BlogComment]].
 *
 * @see \common\models\BlogComment
 */
class BlogCommentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\BlogComment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\BlogComment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byCreateDate(){
        return parent::orderBy(['created_at' => SORT_DESC]);
    }

    public function byBlogId($id) {
        return parent::where(['blog_id'=>$id]);
    }
}
