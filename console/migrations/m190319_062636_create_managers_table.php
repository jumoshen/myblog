<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%managers}}`.
 */
class m190319_062636_create_managers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%managers}}', [
            'id'                   => $this->primaryKey(),
            'username'             => $this->string()->notnull()->comment(''),
            'auth_key'             => $this->string(32)->notnull()->comment(''),
            'password_hash'        => $this->string()->notnull()->comment(''),
            'password_reset_token' => $this->string()->notnull()->comment(''),
            'email'                => $this->string()->notnull()->comment(''),
            'role'                 => $this->string(64)->notnull()->comment('角色'),
            'status'               => $this->smallInteger(6)->notnull()->defaultValue(10),

            'mobile'   => $this->string(50)->notnull()->comment('手机号'),
            'branch'   => $this->string(11)->notnull()->comment('分之'),
            'realname' => $this->string(50)->notnull()->comment('姓名'),

            'created_at' => $this->string()->notnull(),
            'updated_at' => $this->string()->notnull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%managers}}');
    }
}
