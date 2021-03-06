<?php


namespace core\Forms\backend\Trees;


use core\ActiveRecord\Apples\AppleColors;
use core\ActiveRecord\Trees\Trees;
use yii\base\Model;

class CreateAppleForm extends Model
{
    public $color_id;
    private $tree;

    public function __construct(Trees $tree, $config = [])
    {
        parent::__construct($config);
        $this->tree = $tree;
    }

    public function rules()
    {
        return [
            [['color_id'], 'exist', 'targetClass' => AppleColors::className(), 'targetAttribute' => ['color_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'color_id' => 'Выберите цвет яблока'
        ];
    }

    public function getTree()
    {
        return $this->tree;
    }
}