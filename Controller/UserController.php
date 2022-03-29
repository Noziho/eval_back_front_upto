<?php


use App\Controller\AbstractController;
use App\Model\Manager\UserManager;

class UserController extends AbstractController
{

    public function index()
    {
        $this->render('users/list-user');
    }

    public function register()
    {
        $this->render('home/register');
        if (isset($_POST['submit'])) {
            if (!$this->formIsset('username', 'mail', 'password', 'password_repeat', 'submit')) {
                header("Location: /index.php?c=user&a=register&f=0");
            }

            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $mail = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];
            $password_repeat = $_POST['password_repeat'];
            if (!$mail) {
                header("Location: /index.php?c=user&a=register&f=1");
            }
            if (UserManager::mailExist($mail)) {
                header("Location: /index.php?c=user&a=register&f=7");
            }

            if (UserManager::usernameExist($username)) {
                header("Location: /index.php?c=user&a=register&f=8");
            }

            $this->checkRange($username, 4, 75, '/index.php?c=user&a=register&f=2');
            $this->checkRange($mail, 8, 150, '/index.php?c=user&a=register&f=3');
            $this->checkRange($password, 8, 50, '/index.php?c=user&a=register&f=4');


            if (!$this->checkPassword($password, $password_repeat)) {
                header("Location: /index.php?c=user&a=register&f=5");
                exit();
            }

            $password = password_hash($_POST['password'], PASSWORD_ARGON2I);
            UserManager::createUser($username, $mail, $password);
            header("Location: /index.php?c=user&a=register&f=6");
        }
    }

    public function login () {
        $this->render("home/login");
        if (isset($_POST['submit'])) {
            if (!$this->formIsset('username_login', 'password_login')) {
                header("Location: /index.php?c=login&f=3");
            }
            UserManager::login();
        }
    }

    public function dislog () {
        UserManager::dislog();
    }

    public function getAll () {

        $this->render('users/list-user', [
            'users' => UserManager::getAll()
        ]);
    }

    public function showUser (int $id) {
        if (UserManager::userExist($id)) {
            $this->render('users/show-user', [
                "user" => UserManager::getUserById($id),
            ]);
        }
        else {
            $this->index();
        }
    }

    public function editUser (int $id) {
        $this->render('users/edit-user', [
            'user' => UserManager::getUserById($id),
            'users' => UserManager::getAll(),
        ]);
        if (isset($_POST['submit-edit'])) {
            if (!$this->formIsset('username', 'mail', 'role')) {
                header("Location: /index.php?c=user&a=list-user");
            }

            if (UserManager::userExist($id)) {
                $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
                $role = $_POST['role'];
                UserManager::editUser($role, $username, $id);
                header("Location: /index.php?c=user&a=show-user&id={$id}&f=0");
            }
        }

    }

    public function deleteUser (int $id) {
        if (UserManager::userExist($id)) {
            UserManager::deleteUser($id);
            $this->render('users/list-user', [
                "user" => UserManager::getUserById($id),
            ]);
        }
        else {
            $this->index();
        }
    }
}