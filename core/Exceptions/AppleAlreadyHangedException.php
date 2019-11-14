<?php


namespace core\Exceptions;


use yii\base\UserException;

class AppleAlreadyHangedException extends UserException
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = 'Яблоко уже висит на дереве.';
    }
}