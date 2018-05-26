<?php

namespace App\Controllers;

use App\Authentication\User;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig_Environment;
use Twig_Loader_Filesystem;
use App\Authentication\Encoder\UserPasswordEncoder;

class LoginController
{
    /**
     * @var ContainerBuilder
     */
    protected $container;
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Response
     */
    protected $response;

    /**
     * BaseController constructor.
     * @param ContainerBuilder $container
     * @param Request $request
     */
    public function __construct(ContainerBuilder $container, Request $request)
    {
        $this->container = $container;
        $this->request = $request;
        $this->response = new Response();
    }

    /**
     * @return Response
     * @throws \Exception
     */
    public function signInAction(): Response
    {
        $data = [];
        $current_cookie = $this->request->cookies->get('auth_cookie');
        if ($this->isPost()) {
            $login = $this->request->request->getAlnum('login');
            $pass = $this->request->request->getAlnum('password');
            if (strlen($login) < 1 || strlen($pass) < 1){
                $this->render('singIn.html.twig', $data);
                return $this->response;
            }
            $user = new User(null, $login, $pass);

            $current_cookie = $this->container->get('auth')->generateCredentials($user);
            $cookie = new Cookie('auth_cookie', $current_cookie);
            $this->response->headers->setCookie($cookie);
            //todo спросить как по нормльному шифровать куки, и нужноли сохранять в них пароль с логинов
        }
        $userToken = $this->container->get('auth')->authenticate($current_cookie);

        if (!$userToken->isAnonymous()) {
            $data['login'] = $userToken->getUser()->getLogin();
            $this->render('profile.html.twig', $data);
            return $this->response;
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
        $data = []; //todo след задание о себе, модификация юзера, отдельная таблица в БД
        if ($this->isPost()) {
            $enc = new UserPasswordEncoder();
            $data['login'] = $this->request->request->getAlnum('login');
            $pass = $enc->encodePassword($this->request->request->getAlnum('password'));
            $user = new User(null, $data['login'], $pass);
            if (strlen($data['login']) > 0 || strlen($pass) > 0){
                $this->container->get('repos')->save($user);
                $this->render('signIn.html.twig', $data);
                return $this->response;
            }
        }

        $this->render('registration.html.twig', $data);
        return $this->response;
    }

    /**
     * @param string $templateName
     * @param array $params
     * @return bool
     */
    protected function render(string $templateName, array $params = []): bool
    {
        try {
            $this->response->setContent($this->container->get('twig')->render($templateName, $params));
            return true;
        } catch (\Exception $e) {
            return false;
        }
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