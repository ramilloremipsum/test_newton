<?php

use yii\db\Migration;

/**
 * Class m191114_150011_initial_data
 */
class m191114_150011_initial_data extends Migration
{

    public function safeUp()
    {
        $this->execute(file_get_contents(__DIR__ . '/sql/initial_data.sql'));
    }

    public function safeDown()
    {
        return true;
    }

}
