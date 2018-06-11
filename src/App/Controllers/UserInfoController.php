<?php

namespace App\Controllers;


use App\Authentication\Repository\UserInfoRepository;
use App\Authentication\Repository\UserInfoRepositoryInterface;
use App\Authentication\Repository\UserRepository;
use App\Authentication\UserInfoInterface;
use App\Authentication\UserTokenInterface;
use function Sodium\crypto_box_publickey_from_secretkey;
use Symfony\Component\HttpFoundation\RedirectResponse;

class UserInfoController extends BaseController
{
    /**
     * @return UserInfoInterface|null
     * @throws \Exception
     */
    public function getUserInfoData(): ?UserInfoInterface
    {
        /** @var $userToken UserTokenInterface*/
        $userToken = $this->getUserToken();
        if (!$userToken->isAnonymous()){
            /** @var $userInfoRepos UserInfoRepository */
            $userInfoRepos = $this->container->get(UserInfoRepository::class);
            $data['login'] = $userToken->getUser()->getLogin();
            /** @var $userInfo UserInfoInterface*/
            return $userInfoRepos->findInfo($userToken->getUser());
        }
        return null;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function getUserInfo()
    {
        $data = [];
        if ($this->isGet()) {
            $data['userInfo'] = $this->getUserInfoData();
            $this->render('userInfo.html.twig', $data);
            return $this->response;
        }
        $this->response = new RedirectResponse('/');
        return $this->response;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function updateUserInfo()
    {
        if ($user = $this->getUserToken()->getUser()){
            $data = [];
            if ($this->isGet() && $data['userInfo'] = $this->getUserInfoData()) {
                $this->render('userInfoUpdate.html.twig', $data);
                return $this->response;
            }
            if ($this->isPost()) {
                /** @var $userInfoRepos UserInfoRepositoryInterface */
                $userInfoRepos = $this->container->get(UserInfoRepository::class);
                $firstName = $this->request->request->getAlnum('firstName');
                $secondName = $this->request->request->getAlnum('secondName');
                $sex = $this->request->request->getAlnum('sex');
                $workspace = $this->request->request->getAlnum('workspace');
                $about = $this->request->request->getAlnum('about');
                $userInfoRepos->updateUserInfo($user->getId(), $firstName, $secondName, $sex, $workspace, $about);
                $this->response = new RedirectResponse('/userInfo');
                return $this->response;
            }
        }

        $this->response = new RedirectResponse('/');
        return $this->response;
    }

}