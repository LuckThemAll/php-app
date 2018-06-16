<?php

namespace App\Controllers;


use App\Authentication\Repository\UserInfoRepository;
use App\Authentication\Repository\UserRepository;
use App\Authentication\UserInfo;
use App\Authentication\UserInterface;
use Symfony\Component\HttpFoundation\Response;

class UserInfoApiController extends BaseController
{

    /**
     * @return Response
     * @throws \Exception
     */
    public function getUserInfoJson(): Response
    {
        $a = explode('/', explode('?', $this->request->getRequestUri())[0])[3];
        /** @var $userRepos UserInterface */
        if ($user = $this->container->get(UserRepository::class)->findByLogin($a)) {
            /** @var $userInfo UserInfo */
            $userInfo = $this->container->get(UserInfoRepository::class)->findInfo($user);
            $info = array(
                'id' => $userInfo->getId(),
                'user_id' => $userInfo->getUserId(),
                'firsName' => $userInfo->getFirstName(),
                'secondName' => $userInfo->getFirstName(),
                'sex' => $userInfo->getFirstName(),
                'workspace' => $userInfo->getFirstName(),
                'about' => $userInfo->getAbout()
            );
            $this->response->setContent(json_encode($info));
            return $this->response;
        }
        $this->response->setContent('no such user');
        return $this->response;
    }
}