<?php
$db = new PDO('mysql:host=localhost;dbname=spotify_clone', 'root', 'password');

// Include Models
require 'models/PlaylistModel.php';
require 'models/UserModel.php';

// Include Controllers
require 'controllers/HomeController.php';
require 'controllers/UserController.php';

// Instantiate Models
$playlistModel = new PlaylistModel($db);
$userModel = new UserModel($db);

// Instantiate Controllers
$homeController = new HomeController($playlistModel);
$userController = new UserController($userModel);

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':
        $homeController->index();
        break;
    case 'register':
        $userController->register();
        break;
    default:
        echo "404 - Page not found";
        break;
}