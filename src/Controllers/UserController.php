<?php

namespace ProjetA2Phoenix2026\Controllers;

use ProjetA2Phoenix2026\Models\UserManager;
use ProjetA2Phoenix2026\Validator;

/** Class UserController **/
class UserController {
    private $manager;
    private $validator;

    public function __construct() {
        $this->manager = new UserManager();
        $this->validator = new Validator();
    }

    public function showLogin() {
        require VIEWS . 'Auth/login.php';
    }

    public function showRegister() {
        require VIEWS . 'Auth/register.php';
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /login/');
    }

    public function register() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? ($_POST['passwordConfirm'] ?? '');

        // sauvegarde des anciennes valeurs pour la vue
        $_SESSION['old'] = $_POST;

        // validations minimales via Validator (tu peux étendre)
        $this->validator->validate([
            "username" => ["required", "min:3", "alphaNum"],
            "password" => ["required", "min:6", "alphaNum"],
            "email"    => ["required", "email"]
        ]);

        if ($this->validator->errors()) {
            header('Location: /register');
            exit;
        }

        if ($password !== $passwordConfirm) {
            $_SESSION['error']['password_confirm'] = 'Les mots de passe ne correspondent pas';
            header('Location: /register');
            exit;
        }

        // unicité
        if ($this->manager->findByEmail($email)) {
            $_SESSION['error']['email'] = 'Cet e-mail est déjà utilisé';
            header('Location: /register');
            exit;
        }
        if ($this->manager->find($username)) {
            $_SESSION['error']['username'] = 'Ce nom d\'utilisateur est déjà utilisé';
            header('Location: /register');
            exit;
        }

        // création
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $id = $this->manager->create($username, $email, $hash);

        // authentification
        $_SESSION['user'] = [
            "id" => $id,
            "username" => $username,
            "email" => $email
        ];

        header("Location: /");
        exit;
    }

    public function login() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // validation minimale
        $this->validator->validate([
            "username"=>["required", "min:3", "max:9", "alphaNum"],
            "password"=>["required", "min:6", "alphaNum"]
        ]);
        $_SESSION['old'] = $_POST;

        if ($this->validator->errors()) {
            header("Location: /login");
            exit;
        }

        $user = $this->manager->find($username);

        if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
            $_SESSION["user"] = [
                "id" => $user['id'] ?? null,
                "username" => $user['username'] ?? $username,
                "email" => $user['email'] ?? null
            ];
            header("Location: /");
            exit;
        } else {
            $_SESSION["error"]['message'] = "Erreur sur utilisateur ou mot de passe";
            header("Location: /login");
            exit;
        }
    }

}