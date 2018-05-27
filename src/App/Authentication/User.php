<?php

namespace App\Authentication;

class User implements UserInterface
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $login;

    /**
     * @var string|null
     */
    private $password;



    /**
     * User constructor.
     * @param int|null $id
     * @param string $login
     * @param string $password
     */
    public function __construct(?int $id, string $login, string $password)
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * Метод возвращает идентификационную информацию пользователя (первичный ключ в БД пользователей приложения)
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Метод возвращает логин пользователя. Логин является уникальным свойством.
     *
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * Метод возвращает пароль пользователя. Пароль возвращается в зашифрованном виде.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}