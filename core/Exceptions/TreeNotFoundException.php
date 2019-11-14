<?php


namespace core\Exceptions;


use yii\web\NotFoundHttpException;

class TreeNotFoundException extends NotFoundHttpException
{
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = 'Такого дерева не существует. Странно, как так могло произойти?';
    }
}