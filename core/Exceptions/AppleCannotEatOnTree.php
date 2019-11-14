<?php


namespace core\Exceptions;


use yii\base\UserException;

class AppleCannotEatOnTree extends UserException
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = 'К сожалению у тебя нет скиллов точить яблоко прямиком с дерева.';
    }
}