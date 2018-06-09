<?php

namespace App\Authentication;


class UserInfo implements UserInfoInterface{

    private $id;

    private $user_id;

    private $first_name;

    private $second_name;

    private $sex;

    private $workspace;

    private $about;

    /**
     * UserInfo constructor.
     * @param $id
     * @param $user_id
     * @param $first_name
     * @param $second_name
     * @param $sex
     * @param $workspace
     * @param $about
     */
    public function __construct($id, $user_id, $first_name, $second_name, $sex, $workspace, $about)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->first_name = $first_name;
        $this->second_name = $second_name;
        $this->sex = $sex;
        $this->workspace = $workspace;
        $this->about = $about;
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

    /**
     * @return null|string
     */
    public function getAbout(): ?string
    {
        return $this->about;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}