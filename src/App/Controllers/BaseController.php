<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 5/26/2018
 * Time: 3:37 PM
 */

namespace App\Controllers;


use App\Authentication\UserTokenInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $current_cookie = $this->request->cookies->get('auth_cookie');
        $userToken = $this->container->get('auth')->authenticate($current_cookie);
        echo 'from base '.$current_cookie;
        if (!$userToken->isAnonymous()) {
            $data['login'] = $userToken->getUser()->getLogin();
            $this->render('main.html.twig', $data);
            return $this->response;
        }
        $this->render('main.html.twig', $data);
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
}