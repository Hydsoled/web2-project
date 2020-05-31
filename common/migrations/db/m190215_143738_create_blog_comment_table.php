<?php

use yii\db\Migration;

/**
 * Handles the creation of table `blog_comment`.
 * Has foreign keys to the tables:
 *
 * - `blog`
 * - `user`
 */
class m190215_143738_create_blog_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('blog_comment', [
            'id' => $this->primaryKey(),
            'comment' => $this->string(),
            'blog_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);

        // creates index for column `blog_id`
        $this->createIndex(
            'idx-blog_comment-blog_id',
            'blog_comment',
            'blog_id'
        );

        // add foreign key for table `blog`
        $this->addForeignKey(
            'fk-blog_comment-blog_id',
            'blog_comment',
            'blog_id',
            'blog',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            'idx-blog_comment-user_id',
            'blog_comment',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-blog_comment-user_id',
            'blog_comment',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `blog`
        $this->dropForeignKey(
            'fk-blog_comment-blog_id',
            'blog_comment'
        );

        // drops index for column `blog_id`
        $this->dropIndex(
            'idx-blog_comment-blog_id',
            'blog_comment'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-blog_comment-user_id',
            'blog_comment'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-blog_comment-user_id',
            'blog_comment'
        );

        $this->dropTable('blog_comment');
    }
}
