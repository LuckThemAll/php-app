<?php

namespace App\Authentication;

interface UserInfoInterface{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return int
     */
    public function getUserId(): int;

    /**
     * @return null|string
     */
    public function getFirstName(): ?string;

    /**
     * @return null|string
     */
    public function getSecondName(): ?string;

    /**
     * @return null|string
     */
    public function getSex(): ?string;

    /**
     * @return null|string
     */
    public function getWorkSpace(): ?string;


    /**
     * @return null|string
     */
    public function getAbout(): ?string;
}