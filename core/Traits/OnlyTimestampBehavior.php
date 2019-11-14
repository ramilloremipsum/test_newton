<?php

namespace Core\Traits;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

trait OnlyTimestampBehavior
{
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
}