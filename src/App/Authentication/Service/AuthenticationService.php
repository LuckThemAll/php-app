<?php

namespace App\Authentication\Service;


use App\Authentication\Repository\UserRepository;
use App\Authentication\Repository\UserRepositoryInterface;
use App\Authentication\UserInterface;
use App\Authentication\UserToken;
use App\Authentication\UserTokenInterface;
use Symfony\Component\HttpFoundation\Cookie;

class AuthenticationService implements AuthenticationServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
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
            list($userLogin, $hash) = preg_split("/( )+/", $credentials);
            $user = $this->userRepository->findByLogin($userLogin);

            if (!$user) {
                return new UserToken(null);
            }

            if ($hash == $user->getPassword()){ 
                return new UserToken($user);
            }
        }
        return new UserToken(null);
    }

    /**
     * @param string $login
     * @param string $rawPassword
     * @return UserTokenInterface
     */
    public function authenticateByLogPass(string $login, string $rawPassword)
    {
        if (strlen($login) > 0 || strlen($rawPassword) > 0){
            $user = $this->userRepository->findByLogin($login);

            if (!$user) {
                return new UserToken(null);
            }

            if ($user && password_verify($rawPassword, $user->getPassword())){
                return new UserToken($user);
            }
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
        $db_user = $this->userRepository->findByLogin($user->getLogin());
        if ($db_user && $user->getPassword() == $db_user->getPassword()){
            $cred = $user->getLogin().' '.$user->getPassword();
            return $cred;
        }
        return null;
    }
}