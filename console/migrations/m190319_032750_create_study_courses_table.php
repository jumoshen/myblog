<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%study_courses}}`.
 */
class m190319_032750_create_study_courses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%study_courses}}', [
            'id'            => $this->primaryKey(),
            'user_id'       => $this->integer(50)->null()->comment('创建者id'),
            'course_title'  => $this->string()->null()->comment('教程标题'),
            'course_cover'  => $this->string()->null()->comment('教程封面'),
            'course_intro'  => $this->string()->null()->comment('教程简介'),
            'course_detail' => $this->string()->null()->comment('教程详情'),
            'course_type'   => $this->string()->null()->comment('教程类型'),
            'views'         => $this->integer()->defaultValue(0)->comment('浏览次数'),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%study_courses}}');
    }
}
