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
        if ($this->db){
            echo '<br>connected';
        }
        $q = $this->db->prepare("SELECT  * FROM users WHERE id = ?");
        $q ->bind_param('i', $login);
        $q ->execute();
        $result = $q->get_result()->fetch_assoc();
        $q ->close();
        return new User('3', 'sdfsdfsdfds', 'qeqweqwr');
    }

    /**
     * Метод ищет пользователя по login, возвращает UserInterface если пользователь существует, иначе null
     *
     * @param string $login
     * @return UserInterface|null
     */
    public function findByLogin(string $login): ?UserInterface
    {
        if ($this->db){
            echo '<br>connected';
        }
        $q = $this->db->prepare("SELECT  * FROM users WHERE login = ?");
        $q ->bind_param('s', $login);
        $q ->execute();
        $result = $q->get_result()->fetch_assoc();
        echo '<br>'.$result['login'];
        echo '<br>'.$result['password'];
        $q ->close();
        return new User('3', 'sdfsdfsdfds', 'qeqweqwr');
    }

    /**
     * Метод сохраняет пользоваля в хранилище
     *
     * @param UserInterface $user
     */
    public function save(UserInterface $user)
    {
        echo '<br>'.$user->getPassword();
        $q = $this->db->prepare("insert into users(login, password, salt) values (?,?,?)");
        $q ->bind_param('sss', $user->getLogin(), $user->getPassword(), $user->getSalt());
        $q ->execute();
    }
}