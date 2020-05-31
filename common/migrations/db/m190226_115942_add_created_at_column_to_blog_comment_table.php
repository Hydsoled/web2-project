<?php

use yii\db\Migration;

/**
 * Handles adding created_at to table `blog_comment`.
 */
class m190226_115942_add_created_at_column_to_blog_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('blog_comment', 'created_at', $this->integer()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('blog_comment', 'created_at');
    }
}
