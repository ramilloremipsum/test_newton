<?php


namespace core\Forms\backend\Trees;


use core\ActiveRecord\Apples\AppleColors;
use core\ActiveRecord\Apples\Apples;
use core\ActiveRecord\Trees\Trees;
use yii\base\Model;

class EatAppleForm extends Model
{
    public $eat_percent;
    public $apple;
    public $apple_id;

    public function rules()
    {
        return [
            ['eat_percent', 'filter', 'filter' => [$this, 'normalizeValue']],
            [['eat_percent'], 'integer', 'min' => 0, 'max' => 100, 'message' => false, 'tooSmall' => 'И это тоже нереально', 'tooBig' => 'Как это ты себе представляешь?'],
            [['apple_id'], 'exist', 'skipOnError' => true, 'targetClass' => Apples::className(), 'targetAttribute' => ['apple_id' => 'id']]
        ];
    }

    public function normalizeValue($value)
    {
        return trim($value) == '' ? 0 : $value;
    }
}