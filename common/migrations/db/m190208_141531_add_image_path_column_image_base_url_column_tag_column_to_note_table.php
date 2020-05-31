<?php

use yii\db\Migration;

/**
 * Handles adding image_path_column_image_base_url_column_tag to table `note`.
 */
class m190208_141531_add_image_path_column_image_base_url_column_tag_column_to_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('note', 'image_path', $this->string());
        $this->addColumn('note', 'image_base_url', $this->string());
        $this->addColumn('note', 'tag', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('note', 'image_path');
        $this->dropColumn('note', 'image_base_url');
        $this->dropColumn('note', 'tag');
    }
}
