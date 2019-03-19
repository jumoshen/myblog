<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%course_tag_relations}}`.
 */
class m190319_062613_create_course_tag_relations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%course_tag_relations}}', [
            'id'        => $this->primaryKey(),
            'course_id' => $this->integer()->notnull()->comment('教程id'),
            'tag_id'    => $this->integer()->notnull()->comment('tag id'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%course_tag_relations}}');
    }
}
