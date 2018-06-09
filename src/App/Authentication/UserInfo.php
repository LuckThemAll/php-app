<?php

namespace App\Authentication;


class UserInfo implements UserInfoInterface{

    private $id;

    private $user_id;

    private $firstName;

    private $secondName;

    private $sex;

    private $workspace;

    private $about;

    /**
     * UserInfo constructor.
     * @param $id
     * @param $user_id
     * @param $firstName
     * @param $secondName
     * @param $sex
     * @param $workspace
     * @param $about
     */
    public function __construct($id, $user_id, $firstName, $secondName, $sex, $workspace, $about)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->firstName = $firstName;
        $this->secondName = $secondName;
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
        return $this->firstName;
    }

    /**
     * @return null|string
     */
    public function getSecondName(): ?string
    {
        return $this->secondName;
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