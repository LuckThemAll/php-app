<?php

namespace App\Authentication;

/**
 * Интерфейс зарегистрированного пользователя
 *
 * Interface UserInterface
 * @package App\Authentication
 */
interface UserInterface
{

    const AuthCookieName = 'auth_cookie';

	/**
	 * Метод возвращает идентификационную информацию пользователя (первичный ключ в БД пользователей приложения)
	 *
	 * @return int
	 */
	public function getId(): int;

	/**
	 * Метод возвращает логин пользователя. Логин является уникальным свойством.
	 *
	 * @return string
	 */
	public function getLogin(): string;

	/**
	 * Метод возвращает пароль пользователя. Пароль возвращается в зашифрованном виде.
	 *
	 * @return string
	 */
	public function getPassword(): string;
}