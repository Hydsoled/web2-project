<?php

use yii\db\Migration;

/**
 * Handles the creation of table `blog`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m190215_142052_create_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('blog', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'short_description' => $this->string(),
            'image_path' => $this->string(),
            'image_base_url' => $this->string(),
            'title' => $this->string(),
            'description' => $this->string(),
            'user_id' => $this->integer()
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-blog-user_id',
            'blog',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-blog-user_id',
            'blog',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-blog-user_id',
            'blog'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-blog-user_id',
            'blog'
        );

        $this->dropTable('blog');
    }
}
