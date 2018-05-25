<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require_once './init.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$URI = $_SERVER['REQUEST_URI'];
$string = 'containerM';

$contaiter_m = new $string();
$request = Request::createFromGlobals();



$response = $contaiter_m->route($request);
$response->prepare($request);
$response->send();


