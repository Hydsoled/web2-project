<?php

use yii\db\Migration;

/**
 * Class m190121_081329_create_table_posts
 */
class m190121_081329_create_table_posts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
           'id' => $this->primaryKey(),
           'title' => $this->string(),
           'body' => $this->text(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post}}');

    }


}
