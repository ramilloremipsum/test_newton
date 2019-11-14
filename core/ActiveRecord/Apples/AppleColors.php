<?php

namespace core\ActiveRecord\Apples;

use Yii;

/**
 * This is the model class for table "apple_colors".
 *
 * @property int $id
 * @property string $value
 *
 * @property Apples[] $apples
 */
class AppleColors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple_colors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string', 'max' => 50],
            [['value'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApples()
    {
        return $this->hasMany(Apples::className(), ['color_id' => 'id']);
    }
}
