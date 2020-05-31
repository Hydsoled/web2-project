<?php

use yii\db\Migration;

/**
 * Class m190228_075305_alter_comment_column_from_blog_comment_table
 */
class m190228_075305_alter_comment_column_from_blog_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('blog_comment', 'comment', 'text');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('blog_comment','comment', 'string' );
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190228_075305_alter_comment_column_from_blog_comment_table cannot be reverted.\n";

        return false;
    }
    */
}
