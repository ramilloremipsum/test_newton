<?php

use yii\db\Migration;

/**
 * Class m191112_181935_apples
 */
class m191112_181935_apples extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%apples}}', [
            'id' => $this->primaryKey(),
            'tree_id' => $this->integer()->notNull()->comment('Дерево'),
            'color_id' => $this->integer()->notNull()->comment('Цвет'),
            'size' => $this->float()->notNull()->defaultValue(0)->comment('Процент целостности'),
            'is_on_tree' => $this->boolean()->defaultValue(0)->notNull()->comment('На дереве?'),
            'created_at' => $this->integer()->notNull()->comment('Дата появления'),
            'fell_at' => $this->integer()->null()->comment('Дата падения'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%apples}}');
    }
}
