<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require_once './init.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$URI = $_SERVER['REQUEST_URI'];

$contaiter_m = new containerM();
$request = Request::createFromGlobals();


$response = $contaiter_m->router->parseUri($request);
$response->prepare($request);
$response->send();


