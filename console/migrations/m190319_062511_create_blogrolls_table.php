<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%blogrolls}}`.
 */
class m190319_062511_create_blogrolls_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%blogrolls}}', [
            'id' => $this->primaryKey(),
            'web_name' => $this->string(20)->null()->comment('网站名称'),
            'link' => $this->string(50)->null()->comment('网站链接'),
            'web_logo_link' => $this->string()->null()->comment('网站logo链接'),
            'qq' => $this->string(13)->null()->comment('联系qq'),
            'email' => $this->string(50)->null()->comment('邮箱'),
            'remark' => $this->string(50)->null()->comment('备注'),
            'is_checked' => $this->tinyInteger(2)->defaultValue(0)->comment('是否通过审核'),
            'apply_time' => $this->integer(11)->null()->comment('申请时间'),
            'pass_time' => $this->integer(11)->null()->comment('通过时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%blogrolls}}');
    }
}
