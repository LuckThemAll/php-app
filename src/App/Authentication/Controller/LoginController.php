<?php

namespace App\Authentication\Controller;


use Klein\Klein;
use Klein\Request;
use Klein\Response;
use phpDocumentor\Reflection\Types\Resource_;

class LoginController
{
    protected $url;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get_url(): string
    {
        return $this->url;
    }

    public function signInAction(): Response
    {
        $response = Response::class;
        echo 'mem';
        return $response->send();
    }
}