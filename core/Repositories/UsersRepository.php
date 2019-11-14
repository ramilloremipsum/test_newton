<?php


namespace core\Repositories;


use core\ActiveRecord\Users\Users;
use core\Interfaces\UsersRepositoryInterface;
use yii\base\UserException;

class UsersRepository implements UsersRepositoryInterface
{
    /**
     * @param $login
     * @return Users|null
     * @throws UserException
     */
    public function findByLogin($login)
    {
        if (!$user = Users::findOne(['login' => $login])) {
            throw new UserException('User with such login not found.');
        }
        return $user;
    }
}