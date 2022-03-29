<?php

namespace App\Model\Manager;

use App\Model\Entity\Article;
use App\Model\Entity\User;
use DB_Connect;

class UserManager
{
    public const TABLE = "ndmp22_user";

    public static function getUserById(int $id): ?User
    {
        $query = DB_Connect::dbConnect()->query("SELECT * FROM " . self::TABLE . " WHERE id = $id");
        return $query ? self::makeUser($query->fetch()) : null;
    }

    public static function login()
    {
        $stmt = DB_Connect::dbConnect()->prepare("
            SELECT * FROM ". self::TABLE ." WHERE username = :username
        ");

        $username = filter_var($_POST['username_login']);
        $stmt->bindParam(':username', $username);

        $password_en_clair = $_POST['password_login'];

        if ($stmt->execute()) {
            $password = $stmt->fetch();
            if (isset($password['password'])) {
                if (password_verify($password_en_clair, $password['password'])) {
                    $user = (new User())
                        ->setId($password['id'])
                        ->setUsername($password['username'])
                        ->setMail($password['email']);
                        $user->setRole(RoleManager::getRolesByUserId($user));

                    if(!isset($_SESSION['user'])) {
                        $_SESSION['user'] = $user;
                    }

                    $_SESSION['id'] = $password['id'];
                    header("Location: /index.php?c=home&f=0");
                }
                else {
                    header("Location: /index.php?c=user&a=login&f=0");
                }
            }
             else {
                header("Location: /index.php?c=user&a=login&f=0");
            }
        }
    }

    public static function dislog()
    {
        if (isset($_SESSION['user'])) {
            session_unset();
            session_destroy();
            header("Location: /index.php?c=home&f=1");
        } else {
            header("Location: /index.php?c=home&f=2");
        }

    }


    public static function makeUser(array $data): User
    {
        $user = (new User())
            ->setId($data['id'])
            ->setUsername($data['username'])
            ->setMail($data['email'])
            ->setPassword($data['password']);
        return $user->setRole(RoleManager::getRolesByUserId($user));
    }

    public static function createUser($username, $mail, $password)
    {
        $stmt = DB_Connect::dbConnect()->prepare("
            INSERT INTO " . self::TABLE . " (username, email, password, role_fk)
            VALUES (:username, :email, :password, :role_fk) 
        ");

        $role_fk = 3;

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $mail);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(':role_fk', $role_fk);

        $stmt->execute();
    }

    public static function getAll(): array
    {
        $users = [];

        $query = DB_Connect::dbConnect()->query("SELECT * FROM " . self::TABLE);

        if ($query) {

            foreach ($query->fetchAll() as $user) {
                $users[] = (new User())
                    ->setId($user['id'])
                    ->setUsername($user['username'])
                    ->setMail($user['email']);
            }
        }
        return $users;
    }

    public static function userExist(int $id)
    {
        $query = DB_Connect::dbConnect()->query("SELECT count(*) as cnt FROM " . self::TABLE . " WHERE id = $id");
        return $query ? $query->fetch()['cnt'] : 0;
    }
    public static function mailExist (string $email)
    {
        $query = DB_Connect::dbConnect()->query("SELECT count(*) as cnt FROM " . self::TABLE . " WHERE email = \"$email\"");
        return $query ? $query->fetch()['cnt'] : 0;
    }

    public static function usernameExist (string $username)
    {
        $query = DB_Connect::dbConnect()->query("SELECT count(*) as cnt FROM " . self::TABLE . " WHERE username = \"$username\"");
        return $query ? $query->fetch()['cnt'] : 0;
    }

    public static function editUser(string $role, string $username, int $id) {
        $stmt = DB_Connect::dbConnect()->prepare("
            UPDATE ". self::TABLE ." SET username = :username, role_fk = :role WHERE id = :id
        ");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":role", $role);

        $stmt->execute();

    }

    public static function deleteUser (int $id) {
        $query = DB_Connect::dbConnect()->query("
            DELETE FROM ". self::TABLE ." WHERE id = $id
        ");
        if ($query) {
            header("Location: /index.php?c=user&a=get-all");
        }
        else {
            header("Location: /index.php?c=home");
        }
    }
}