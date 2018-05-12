<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 11.05.2018
 * Time: 14:30
 */

namespace App\Authentication\Service;


use App\Authentication\Repository\UserRepository;
use App\Authentication\UserInterface;
use App\Authentication\UserToken;
use App\Authentication\UserTokenInterface;

class AuthenticationService implements AuthenticationServiceInterface
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Метод аутентифицирует пользователя на основании authentication credentials запроса
     *
     * @param mixed $credentials
     * @return UserTokenInterface
     */
    public function authenticate($credentials)
    {
        if ($credentials) {
            $user = $this->userRepository->findByLogin($credentials->getLogin());
            return new UserToken($user);
        }
        return new UserToken(null);
    }

    /**
     * Метод генерирует authentication credentials
     *
     * @param UserInterface $user
     * @return mixed
     */
    public function generateCredentials(UserInterface $user)
    {
        $userFromDB = $this->userRepository->findByLogin($user->getLogin());
        return $userFromDB;
    }
}