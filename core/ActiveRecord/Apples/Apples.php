<?php

namespace core\ActiveRecord\Apples;

use core\ActiveRecord\Trees\Trees;
use core\Exceptions\AppleCannotEatMoreThanSizeException;
use core\Exceptions\AppleCannotEatOnTree;
use core\Exceptions\AppleCannotEatRotten;
use core\Exceptions\AppleNotBittenException;
use core\Helpers\NewtonHelper;
use Yii;

/**
 * This is the model class for table "apples".
 *
 * @property int $id
 * @property int $tree_id Дерево
 * @property int $color_id Цвет
 * @property double $size Процент целостности
 * @property int $is_on_tree На дереве?
 * @property int $created_at Дата появления
 * @property int $fell_at Дата падения
 *
 * @property AppleColors $color
 * @property Trees $tree
 * @property boolean $isRotten
 * @property double $maxToEat
 * @property double $eaten
 * @property string $timeOnEarth
 */
class Apples extends \yii\db\ActiveRecord
{

    const SECONDS_BEFORE_ROTTEN = 18000;
    const SECONDS_FOR_PSEUDO_RANDOM = 36000;

    const MIN_RANDOM_GENERATE = 1;
    const MAX_RANDOM_GENERATE = 10;
    private $now_timestamp;


    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->now_timestamp = time();
    }

    public static function tableName()
    {
        return 'apples';
    }

    public function rules()
    {
        return [
            [['tree_id', 'color_id', 'created_at'], 'required'],
            [['tree_id', 'color_id', 'is_on_tree', 'created_at', 'fell_at'], 'integer'],
            [['size'], 'number'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppleColors::className(), 'targetAttribute' => ['color_id' => 'id']],
            [['tree_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trees::className(), 'targetAttribute' => ['tree_id' => 'id']],
        ];
    }

    public function getColor()
    {
        return $this->hasOne(AppleColors::className(), ['id' => 'color_id']);
    }

    public function getTree()
    {
        return $this->hasOne(Trees::className(), ['id' => 'tree_id']);
    }

    public function generateCreatedAt()
    {
        $this->created_at = NewtonHelper::pseudoRandomTimestamp(self::SECONDS_FOR_PSEUDO_RANDOM);
    }


    public function getIsRotten()
    {
        return $this->secondsOnEarth() > self::SECONDS_BEFORE_ROTTEN;
    }

    public function getMaxToEat()
    {
        return $this->size * 100;
    }

    public function getEaten()
    {
        return 1 - $this->size;
    }

    public function secondsOnEarth()
    {
        if ($this->fell_at != null) {
            return $this->now_timestamp - $this->fell_at;
        }
        return 0;
    }

    public function getTimeOnEarth()
    {
        if ($this->fell_at == null) {
            return '00:00:00';
        }
        return NewtonHelper::timeBetween($this->fell_at, $this->now_timestamp);
    }

    public function getIsOnEarth()
    {
        return !$this->is_on_tree;
    }

    public function setDropped()
    {
        $this->is_on_tree = 0;
        $this->fell_at = $this->now_timestamp;
    }

    public function setHanged()
    {
        $this->is_on_tree = 1;
    }

    public function eat($eat_percent)
    {
        $eat_percent = $eat_percent / 100;
        if ($this->is_on_tree) {
            throw new AppleCannotEatOnTree();
        }
        if ($this->isRotten) {
            throw new AppleCannotEatRotten();
        }
        if ($eat_percent > $this->size) {
            throw new AppleCannotEatMoreThanSizeException();
        }
        if ($eat_percent == 0) {
            throw new AppleNotBittenException();
        }
        $this->size = $this->size - $eat_percent;
    }

}
