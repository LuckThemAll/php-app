<?php

namespace App\Authentication\Service;


use App\Authentication\Repository\UserRepository;
use App\Authentication\UserInterface;
use App\Authentication\UserToken;
use App\Authentication\UserTokenInterface;
use Symfony\Component\HttpFoundation\Cookie;

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
            $user = $this->userRepository->findByLogin($credentials['login']);
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
        $cred = array(
            'login' => $user->getLogin(),
            'pass'  => $user->getPassword()
        );
        return $cred;
    }
}