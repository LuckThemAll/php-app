<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 5/26/2018
 * Time: 3:37 PM
 */

namespace App\Controllers;


use App\Authentication\Service\AuthenticationService;
use App\Authentication\UserInterface;
use App\Authentication\UserToken;
use App\Authentication\UserTokenInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig_Environment;

class BaseController
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
     * @var $userToken UserTokenInterface
     */
    public function Main(): Response
    {
        $data = [];
        /** @var UserTokenInterface $userToken */
        $userToken = $this->getUserToken();
        if (!$userToken->isAnonymous()) {
            $data['login'] = $userToken->getUser()->getLogin();
            $this->render('main.html.twig', $data);
            return $this->response;
        }
        $this->render('main.html.twig', $data);
        return $this->response;
    }

    /**
     * @return UserToken
     * @throws \Exception
     */
    public function getUserToken(): UserToken
    {
        $current_cookie = $this->request->cookies->get(UserInterface::AuthCookieName);
        return $this->container->get(AuthenticationService::class)->authenticateByCred($current_cookie);
    }

    /**
     * @param string $templateName
     * @param array $params
     * @return bool
     */
    protected function render(string $templateName, array $params = []): bool
    {
        try {
            $this->response->setContent($this->container->get(Twig_Environment::class)->render($templateName, $params));
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