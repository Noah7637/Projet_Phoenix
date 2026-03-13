<?php

session_start();

require '../src/config/config.php';
require '../vendor/autoload.php';
require SRC . 'helper.php';
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$logged = isLoggedIn();

$router = new ProjetA2Phoenix2026\Router($_SERVER["REQUEST_URI"]);

$public_routes = [
    '/register',
    '/login',
    '/',
    '/catalogue'
];

if (!in_array($uri, $public_routes) && !$logged) {
    header("Location: /login");
    exit;
} elseif (in_array($uri, $public_routes) && $logged) {
    header("Location: /");
    exit;
}


$router->get('/confirmation', "phoenixController@confirmation");
$router->get('/', "phoenixController@accueil");
$router->get('/reservation', "phoenixController@reservation");
$router->get('/catalogue', "phoenixController@showAll");
$router->get('/login', "UserController@showLogin");
$router->get('/logout', "UserController@logout");
$router->get('/register', "UserController@showRegister");
// $router->get('/dashboard/', "phoenixController@showAll");

$router->post('/register', 'UserController@register');
$router->post('/login', 'UserController@login');





// $router->post('/confirm/:id', "phoenixController@confirm");






// $router->get('/', "phoenixController@showAll");




$router->run();
