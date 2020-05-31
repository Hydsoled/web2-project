<?php

use yii\db\Migration;

/**
 * Handles the creation of table `blog_attachment`.
 * Has foreign keys to the tables:
 *
 * - `blog`
 */
class m190215_143316_create_blog_attachment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('blog_attachment', [
            'id' => $this->primaryKey(),
            'attachment_path' => $this->string(),
            'attachment_base_url' => $this->string(),
            'blog_id' => $this->integer(),
        ]);

        // creates index for column `blog_id`
        $this->createIndex(
            'idx-blog_attachment-blog_id',
            'blog_attachment',
            'blog_id'
        );

        // add foreign key for table `blog`
        $this->addForeignKey(
            'fk-blog_attachment-blog_id',
            'blog_attachment',
            'blog_id',
            'blog',
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
            'fk-blog_attachment-blog_id',
            'blog_attachment'
        );

        // drops index for column `blog_id`
        $this->dropIndex(
            'idx-blog_attachment-blog_id',
            'blog_attachment'
        );

        $this->dropTable('blog_attachment');
    }
}
