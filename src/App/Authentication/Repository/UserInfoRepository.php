<?php

namespace App\Authentication\Repository;

use App\Authentication\UserInterface;
use App\Authentication\UserInfo;
use mysqli;

class UserInfoRepository implements UserInfoRepositoryInterface{

    /**
     * @var mysqli
     */
    private $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }

    public function createUserInfoRecord(UserInterface $user)
    {
        if ($user) {
            $q = $this->db->prepare("insert into user_info (user_id) values (?)");
            $q->bind_param('s', $user->getId());
            $q->execute();
            $q->close();
        }
    }

    /**
     * @param UserInterface $user
     * @return UserInfo|null
     */
    public function findInfo(UserInterface $user): ?UserInfo
    {
        $q = $this->db->prepare("SELECT  * FROM user_info WHERE user_id = ?");
        $q ->bind_param('s', $user->getId());
        $q ->execute();
        if ($result = $q->get_result()->fetch_assoc()){
            $q ->close();
            return new UserInfo($result['user_id'], $result['first_name'], $result['second_name'],
                $result['sex'], $result['workspace']);
        }
        $q ->close();
        return null;
    }

    /**
     * @param $user_id
     * @param $first_name
     * @param $second_name
     * @param $sex
     * @param $workspace
     * @return void
     */
    public function updateUserInfo($user_id, $first_name, $second_name, $sex, $workspace): void
    {
        $q = $this->db->prepare("update user_info set first_name=?, second_name=?, sex=?, workspace=? where user_id = ?");
        $q->bind_param('ssssi', $first_name, $second_name, $sex, $workspace, $user_id);
        $q->execute();
        $q->close();
        return;
    }
}