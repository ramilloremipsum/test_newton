<?php


namespace core\Exceptions;


use yii\base\UserException;

class AppleCannotEatRotten extends UserException
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = 'Фу фу';
    }
}