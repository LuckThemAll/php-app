<?php
namespace App\Authentication\Encoder;


class UserPasswordEncoder implements UserPasswordEncoderInterface
{

    /**
     * Метод принимает чистый пароль и соль (опциональна) и возвращает в зашифрованном виде.
     *
     * @param string $rawPassword
     * @param null|string $salt
     * @return string
     */
    public function encodePassword(string $rawPassword, ?string $salt = null): string
    {
        $hash1 = md5($rawPassword);
        $saltedHash = md5($hash1 . $salt);
        return $saltedHash;
    }
}