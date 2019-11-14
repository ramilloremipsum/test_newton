<?php

namespace core\ActiveRecord\Trees;

use core\ActiveRecord\Apples\Apples;
use core\Traits\BehaviorForDataTrait;
use Yii;

/**
 * This is the model class for table "trees".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property Apples[] $apples
 * @property int $applesCount
 */
class Trees extends \yii\db\ActiveRecord
{
    use BehaviorForDataTrait;

    public static function tableName()
    {
        return 'trees';
    }
    public function getApples()
    {
        return $this->hasMany(Apples::className(), ['tree_id' => 'id'])->orderBy('id DESC');
    }
    public function getApplesCount()
    {
        return $this->hasMany(Apples::className(), ['tree_id' => 'id'])->count();
    }

}
