<?php

namespace ProjetA2Phoenix2026\Controllers;

use ProjetA2Phoenix2026\Models\phoenixManager;
use ProjetA2Phoenix2026\Models\UserManager;
use ProjetA2Phoenix2026\Validator;

/** Class UserController **/
class phoenixController {
    private $manager;
    private UserManager $userManager;
    private Validator $validator;

    public function __construct() {
        $this->manager = new phoenixManager();
        $this->userManager = new UserManager();
        $this->validator = new Validator();
    }

    public function confirmation() {
        require VIEWS . 'confirmation.php';
    }

    public function accueil() {
         require VIEWS . 'accueil.php';
    }

    public function reservation() {
         require VIEWS . 'reservation.php';
    }
    
    public function login() {
         require VIEWS . 'Auth/login.php';
    }

    public function register() {
         require VIEWS . 'Auth/register.php';
    }

    // Handle registration POST
    public function registerStore() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /register");
            exit;
        }

        $data = [
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
        ];

        $errors = $this->validator->validateRegistration($data);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $data;
            header("Location: /register");
            exit;
        }

        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->userManager->create($data['username'], $data['email'], $hash);

        header("Location: /login?registered=1");
        exit;
    }

    // Handle login POST
    public function loginAttempt() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /login");
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = $this->validator->validateLogin(['email' => $email, 'password' => $password]);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: /login");
            exit;
        }

        $user = $this->userManager->findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['errors'] = ['email' => 'Identifiants invalides'];
            header("Location: /login");
            exit;
        }

        // Authenticated
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
        ];

        header("Location: /");
        exit;
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        unset($_SESSION['user']);
        header("Location: /");
        exit;
    }

    public function store() {
        $this->manager->store($_POST['nameTask'], $_POST["list_id"]);
        header("Location: /register/confirm");
        exit;
    }

    public function showAll() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        
        $travels = $this->manager->getAll();
        
        ob_start();
        require VIEWS . 'catalogue.php';
        $content = ob_get_clean();
        require VIEWS . 'layout.php';
    }
}