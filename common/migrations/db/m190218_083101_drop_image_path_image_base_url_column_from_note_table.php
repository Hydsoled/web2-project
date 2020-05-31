<?php

use yii\db\Migration;

/**
 * Handles dropping image_path_image_base_url from table `note`.
 */
class m190218_083101_drop_image_path_image_base_url_column_from_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('note', 'image_path');
        $this->dropColumn('note', 'image_base_url');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('note', 'image_path', $this->varchar(255));
        $this->addColumn('note', 'image_base_url', $this->varchar(255));
    }
}
