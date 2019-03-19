<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'                   => $this->primaryKey(),
            'username'             => $this->string()->notNull()->unique(),
            'auth_key'             => $this->string(32)->notNull(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email'                => $this->string()->null()->comment('邮件'),

            'status'      => $this->smallInteger()->notNull()->defaultValue(10)->comment('状态： 10：active'),
            'nickname'    => $this->string(50)->null()->comment('昵称'),
            'realname'    => $this->string(50)->null()->comment('姓名'),
            'sex'         => $this->smallInteger(1)->defaultValue(0)->comment('性别 0/1/2 保密/男/女'),
            'province'    => $this->string(32)->null()->comment('省份'),
            'mobile'      => $this->string(15)->null()->comment('手机号'),
            'head_avatar' => $this->string()->null()->comment('头像'),
            'qq_openid'   => $this->string(32)->null()->comment('qq openid'),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
