<?php

use App\Authentication\Repository\UserRepository;
use App\Authentication\Service\AuthenticationService;
use App\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class containerM
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * containerM constructor.
     */
    public function __construct()
    {
        $this->container = new ContainerBuilder();

        $twig_loader = new Twig_Loader_Filesystem(__DIR__.'/../templates');
        $this->container->register(Twig_Environment::class, Twig_Environment::class)
            ->setArguments([$twig_loader]);

        $this->container->register(mysqli::class, mysqli::class)
            ->setArguments([
                'mysql',
                'app',
                'app',
                'test'
            ]);

        $this->container->register(UserRepository::class, UserRepository::class)
            ->setArguments([new Reference(mysqli::class)]);

        $this->container->register(AuthenticationService::class, AuthenticationService::class)
            ->setArguments([new Reference(UserRepository::class)]);

        $this->router = new Router($this->container);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function route(Request $request)
    {
        return $this->router->parseUri($request);
    }
}