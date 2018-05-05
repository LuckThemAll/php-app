<?php

require_once './init.php';
use App\Authentication\Controller\LoginController;
$con = mysqli_connect('mysql','app', 'app', 'test');

$loader = new Twig_Loader_Filesystem('/data/templates');
$twig = new Twig_Environment($loader);

$klein = new \Klein\Klein();


/**
 * @param $request
 * @param $response
 * @param $service
 * @param $app
 */
//$klein->respond(array('POST', 'GET'), '/[login|registration:action]?/', function ($request, $response) {
//    switch ($request->action) {
//        case 'login':
//            echo 'nenene';
//            return (new LoginController($request))->signInAction();
//    }
//    return 0;
//});
//
$klein->respond('GET', '/login', function ($request, $response) use ($twig){
    echo $_POST['username'];
    echo $request->body();
    return $twig->render('login.html', array('the' => 'variables', 'go' => 'here')); //todo return response;
});
//
//$klein->respond('GET', '/registration', function () use ($twig){
//    echo $_POST['username'];
//    return $twig->render('registration.html', array('the' => 'variables', 'go' => 'here'));
//});
$klein->dispatch();

