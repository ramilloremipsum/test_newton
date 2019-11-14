<?php
namespace core\Traits;


use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

trait BehaviorForDataWithSlugTrait
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
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                'defaultValue' => 0
            ],
            'slug' => [
                'class' => SlugBehavior::className(),
                'slugAttribute' => 'slug',
                'attribute' => $this->hasAttribute('title') ? 'title' : 'name',
                'ensureUnique' => true,
                'slugifyOptions' => [
                    'lowercase' => true,
                    'separator' => '-',
                    'trim' => true,
                    'rulesets' => [
                        'russian'
                    ]
                ]
            ],
        ];
    }
}