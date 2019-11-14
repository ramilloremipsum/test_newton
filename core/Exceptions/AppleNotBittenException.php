<?php


namespace core\Exceptions;


use yii\base\UserException;

class AppleNotBittenException extends UserException
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = 'Кусай говорю.';
    }
}