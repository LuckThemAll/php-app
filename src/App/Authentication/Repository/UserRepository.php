<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 12.05.2018
 * Time: 8:29
 */

namespace App\Authentication\Repository;


use App\Authentication\User;
use App\Authentication\UserInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var \mysqli
     */
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Метод ищет пользователя по индентификатору, возвращает UserInterface если пользователь существует, иначе null
     *
     * @param int $id
     * @return UserInterface|null
     */
    public function findById(int $id): ?UserInterface
    {
        $q = $this->db->prepare("SELECT  * FROM users WHERE id = ?");
        $q ->bind_param('s', $id);
        $q ->execute();
        if ($result = $q->get_result()->fetch_assoc()){
            $q ->close();
            return new User($result['id'], $result['login'], $result['password']);
        }
        $q ->close();
        return null;
    }

    /**
     * Метод ищет пользователя по login, возвращает UserInterface если пользователь существует, иначе null
     *
     * @param string $login
     * @return UserInterface|null
     */
    public function findByLogin(string $login): ?UserInterface
    {
        $q = $this->db->prepare("SELECT  * FROM users WHERE login = ?");
        $q ->bind_param('s', $login);
        $q ->execute();
        if ($result = $q->get_result()->fetch_assoc()){
            $q ->close();
            return new User($result['id'], $result['login'], $result['password']);
        }
        $q ->close();
        return null;
    }

    /**
     * Метод сохраняет пользоваля в хранилище
     *
     * @param UserInterface $user
     */
    public function save(UserInterface $user)
    {
        if ($user) {
            $q = $this->db->prepare("insert into users(login, password) values (?,?)");
            $q->bind_param('ss', $user->getLogin(), $user->getPassword());
            $q->execute();
            $q->close();
        }
    }
}