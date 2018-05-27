<?php

namespace App\Routing;

use App\Controllers\BaseController;
use App\Controllers\LoginController;
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
     * @return string|404 ERROR
     */
    function Start(Request $request) {

        $uri    = $request->getRequestUri();
        $link   = explode('/', $uri);
        //todo  host/Login/signIn
        $controller = $link[1];
        $action     = $link[2];

        if($controller == '') {
            $controller = 'login';
        }

        if($action == '') {
            $action = 'signIn';
        }

        $action = $action.'Action';
        $controller_name    = $controller.'Controller';
        $controller_file    = $controller.'Controller'.'.php';
        $controller_path    = __DIR__.'/../Controllers/'.$controller_file;
        $controller_namespace = 'App\\Controllers\\';

        echo $controller_path;
        if(file_exists($controller_path)) {
            new LoginController();
            echo '<br>file is EXIST!!!';
            require_once($controller_path);
            $controller = new $controller_namespace.$controller_name($this->container, $request);

            if(!method_exists($controller, $action)) {
                //todo return error404
                return null;
            }
            return $controller->$action();

        }
        //todo return error404
        return null;
    }

    /**
     * @param Request $request
     * @return string
     */
    public function get_uri(Request $request): string
    {
        return explode('?', $request->getRequestUri())[0];
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function parseUri(Request $request): Response
    {
        $URI = $this->get_uri($request);
        switch ($URI) {
            case '/':{
                return (new BaseController($this->container, $request))->Main();
            }
            case '/signIn':{
                return (new LoginController($this->container, $request))->signInAction();
            }
            case '/registration':
                return (new LoginController($this->container, $request))->registerAction();
            case '/logout':
                return (new LoginController($this->container, $request))->logoutAction();
            default:
                return new Response("404", 404);
        }
    }
        
}