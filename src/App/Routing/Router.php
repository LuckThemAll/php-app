<?php

namespace App\Routing;

use App\Controller\LoginController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    
    /**
     * @ContainerBuilder
     */
    private $container;

    public function __construct(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function parseUri(Request $request): Response
    {
        $URI = explode('?', $request->getRequestUri())[0];
        switch ($URI) {
            case '/':{
                return (new LoginController($this->container, $request))->signInAction();
            }
            case '/signIn':{
                return (new LoginController($this->container, $request))->signInAction();
            }
            case '/registration':
                return (new LoginController($this->container, $request))->registerAction();
//            case '/logout':
//                return (new LoginController($this->container, $request))->logoutAction();
            default:
                return new Response("404", 404);
        }
    }
        
}