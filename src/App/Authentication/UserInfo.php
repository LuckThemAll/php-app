<?php

use App\Authentication\UserInterface;

class UserInfo implements UserInfoInterface{

    private $user_id;

    private $first_name;

    private $second_name;

    private $sex;

    private $workspace;

    /**
     * UserInfo constructor.
     * @param $user_id
     * @param $first_name
     * @param $second_name
     * @param $sex
     * @param $workspace
     */
    public function __construct($user_id, $first_name, $second_name, $sex, $workspace)
    {
        $this->user_id = $user_id;
        $this->first_name = $first_name;
        $this->second_name = $second_name;
        $this->sex = $sex;
        $this->workspace = $workspace;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @return null|string
     */
    public function getSecondName(): ?string
    {
        return $this->second_name;
    }

    /**
     * @return null|string
     */
    public function getSex(): ?string
    {
        return $this->sex;
    }

    /**
     * @return null|string
     */
    public function getWorkSpace(): ?string
    {
        return $this->workspace;
    }
}