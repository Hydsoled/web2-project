<?php

use yii\db\Migration;

/**
 * Handles adding blog_id to table `note`.
 * Has foreign keys to the tables:
 *
 * - `blog`
 */
class m190215_144523_add_blog_id_column_to_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('note', 'blog_id', $this->integer());

        // creates index for column `blog_id`
        $this->createIndex(
            'idx-note-blog_id',
            'note',
            'blog_id'
        );

        // add foreign key for table `blog`
        $this->addForeignKey(
            'fk-note-blog_id',
            'note',
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
            'fk-note-blog_id',
            'note'
        );

        // drops index for column `blog_id`
        $this->dropIndex(
            'idx-note-blog_id',
            'note'
        );

        $this->dropColumn('note', 'blog_id');
    }
}
