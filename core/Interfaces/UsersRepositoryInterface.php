<?php


namespace core\Interfaces;


interface UsersRepositoryInterface
{
    public function findByLogin($login);
}