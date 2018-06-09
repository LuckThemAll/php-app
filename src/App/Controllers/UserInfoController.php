<?php

namespace App\Controllers;


use App\Authentication\Service\AuthenticationService;
use App\Authentication\UserInterface;

class UserInfoController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function getUserInfo()
    {

        $data = [];
        if ($this->isPost()) {

        }
        $this->render('profile.html.twig', $data);
        return $this->response;
    }

    public function UpdateUserInfo()
    {

    }
}