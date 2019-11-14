<?php

use yii\db\Migration;

/**
 * Class m191112_184305_keys
 */
class m191112_184305_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk-apples-apple_colors', '{{%apples}}', 'color_id', '{{%apple_colors}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-apples-apple_colors', '{{%apples}}');
    }
}
