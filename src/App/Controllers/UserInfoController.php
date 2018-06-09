<?php

namespace App\Controllers;


use App\Authentication\Repository\UserInfoRepository;
use App\Authentication\UserInfoInterface;
use App\Authentication\UserTokenInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserInfoController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function getUserInfo()
    {

        $data = [];
        if ($this->isGet()) {
            /** @var $userToken UserTokenInterface*/
            $userToken = $this->getUserToken();
            if (!$userToken->isAnonymous()){
                /** @var $userInfoRepos UserInfoRepository */
                $userInfoRepos = $this->container->get(UserInfoRepository::class);
                $data['login'] = $userToken->getUser()->getLogin();
                /** @var $userInfo UserInfoInterface*/
                $userInfo = $userInfoRepos->findInfo($userToken->getUser());
                $data['userInfo'] = $userInfo;
                $this->render('userInfo.html.twig', $data);
                return $this->response;
            }
        }
        $this->response = new RedirectResponse('/');
        return $this->response;
    }

    public function UpdateUserInfo()
    {

    }
}