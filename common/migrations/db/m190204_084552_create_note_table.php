<?php

use yii\db\Migration;

/**
 * Handles the creation of table `note`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m190204_084552_create_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('note', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'body' => $this->text(),
            'title' => $this->text(),
            'user_id' => $this->integer(),
            'api_id' => $this->integer(11),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-note-user_id',
            'note',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-note-user_id',
            'note',
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
            'fk-note-user_id',
            'note'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-note-user_id',
            'note'
        );

        $this->dropTable('note');
    }
}
