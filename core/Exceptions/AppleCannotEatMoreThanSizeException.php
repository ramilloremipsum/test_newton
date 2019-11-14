<?php


namespace core\Exceptions;


use yii\base\UserException;

class AppleCannotEatMoreThanSIzeException extends UserException
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = 'Не можно съесть больше чем дают! Целься точнее.';
    }
}