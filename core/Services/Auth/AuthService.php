<?php


namespace core\Services\Auth;


use core\ActiveRecord\Users\Users;
use core\Forms\backend\LoginForm;
use core\Repositories\UsersRepository;
use yii\base\UserException;
/**
 * @property UsersRepository $usersRepository
 */
class AuthService
{
    public $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }


    /**
     * @param LoginForm $form
     * @return Users|null
     * @throws UserException
     */
    public function auth(LoginForm $form)
    {
        $user = $this->usersRepository->findByLogin($form->login);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new UserException('Undefined user or password');
        }
        return $user;
    }
}