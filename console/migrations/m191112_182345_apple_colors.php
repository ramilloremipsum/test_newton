<?php

use yii\db\Migration;

/**
 * Class m191112_182345_apple_colors
 */
class m191112_182345_apple_colors extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%apple_colors}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string(50)->notNull()->unique(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%apple_colors}}');
    }
}
