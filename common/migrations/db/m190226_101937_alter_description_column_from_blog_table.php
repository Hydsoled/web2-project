<?php

use yii\db\Migration;

/**
 * Class m190226_101937_alter_description_column_from_blog_table
 */
class m190226_101937_alter_description_column_from_blog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('blog', 'description', 'text');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->alterColumn('blog', 'description', 'string');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190226_101937_alter_description_column_from_blog_table cannot be reverted.\n";

        return false;
    }
    */
}
