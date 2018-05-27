<?php

namespace App\Controllers;

use App\Authentication\Repository\UserRepository;
use App\Authentication\Service\AuthenticationService;
use App\Authentication\User;
use App\Authentication\UserInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Authentication\Encoder\UserPasswordEncoder;

class LoginController extends BaseController
{
    /**
     * @return Response
     * @throws \Exception
     */
    public function signInAction(): Response
    {
        $data = [];
        if ($this->isPost()) {
            $login = $this->request->request->getAlnum('login');
            $pass = $this->request->request->getAlnum('password');
            if (strlen($login) < 1 || strlen($pass) < 1){
                $this->render('singIn.html.twig', $data);
                return $this->response;
            }
            $userToken = $this->container->get(AuthenticationService::class)->authenticateByLogPass($login, $pass);

            if (!$userToken->isAnonymous()) {
                $cookie = $this->container->get(AuthenticationService::class)->generateCredentials($userToken->getUser());
                $cookie = new Cookie(UserInterface::AuthCookieName, $cookie);
                $this->response->headers->setCookie($cookie);
                $data['login'] = $userToken->getUser()->getLogin();
                $this->render('profile.html.twig', $data);
                return $this->response;
            }
        }
        $this->render('signIn.html.twig', $data);
        return $this->response;
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function registerAction(): Response
    {
        $data = [];
        if ($this->isPost()) {
            $enc = new UserPasswordEncoder();
            $data['login'] = $this->request->request->getAlnum('login');
            $pass = $enc->encodePassword($this->request->request->getAlnum('password'));
            $user = new User(null, $data['login'], $pass);
            if (strlen($data['login']) > 0 && strlen($pass) > 0){
                $this->container->get(UserRepository::class)->save($user);
                $cookie = $this->container->get(AuthenticationService::class)->generateCredentials($user);
                $cookie = new Cookie(UserInterface::AuthCookieName, $cookie);
                $this->response = new RedirectResponse('/');
                $this->response->headers->setCookie($cookie);
                return $this->response;
            }
        }
        $this->render('registration.html.twig', $data);
        return $this->response;
    }

    public function logoutAction(): Response
    {
        $this->response = new RedirectResponse('/');
        $this->response->headers->clearCookie(UserInterface::AuthCookieName);
        return $this->response;
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->request->isMethod('POST');
    }

    /**
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->request->isMethod('GET');
    }
}