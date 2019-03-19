<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%organizations}}`.
 */
class m190319_062834_create_organizations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%organizations}}', [
            'org_id' => $this->primaryKey(),
            'org_name' => $this->string()->notnull()->comment('机构名称'),
            'parent_id' => $this->integer()->notnull()->comment('机构父ID'),
            'parent_path' => $this->string(50)->notnull()->comment('机构路径'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%organizations}}');
    }
}
