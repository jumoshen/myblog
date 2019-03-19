<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%manager_logs}}`.
 */
class m190319_062723_create_manager_logs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%manager_logs}}', [
            'log_id' => $this->primaryKey(),
            'manager_id' => $this->integer(11)->notnull()->defaultValue(0)->comment('管理员id'),
            'module_name' => $this->string(50)->notnull()->comment('模块名称'),
            'operate_type' => $this->tinyInteger(2)->defaultValue(0)->notnull()->comment('操作类型（0添加，1编辑,2删除）'),
            'operate_content' => $this->string(50)->notnull()->comment('操作内容（如产品名称'),
            'created_at' => $this->integer()->notnull()->comment('创建时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%manager_logs}}');
    }
}
