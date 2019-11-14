<?php

use yii\db\Migration;

/**
 * Class m191112_200707_keys
 */
class m191112_200707_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk-apples-trees', '{{%apples}}', 'tree_id', '{{%trees}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-apples-trees', '{{%apples}}');
    }
}
