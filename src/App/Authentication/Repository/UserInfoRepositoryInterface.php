<?php

namespace App\Authentication\Repository;

use App\Authentication\UserInterface;
use App\Authentication\UserInfo;

interface UserInfoRepositoryInterface{

    /**
     * @param UserInterface $user
     * @return UserInfo|null
     */
    public function findInfo(UserInterface $user): ?UserInfo;

    /**
     * @param UserInterface $user
     * @return null
     */
    public function createUserInfoRecord(UserInterface $user);

    /**
     * @param $user_id
     * @param $first_name
     * @param $second_name
     * @param $sex
     * @param $workspace
     * @param $about
     * @return void
     */
    public function updateUserInfo($user_id, $first_name, $second_name, $sex, $workspace, $about): void;


}