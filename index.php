<?php
session_start(); // Start the session

// Database connection
$db = new PDO('mysql:host=localhost;dbname=spotify_clone', 'root', 'password');

// Include Models
require 'models/UserModel.php';
require 'models/PlaylistModel.php';

// Include Controllers
require 'controllers/HomeController.php';
require 'controllers/UserController.php';

// Instantiate Models
$userModel = new UserModel($db);
$playlistModel = new PlaylistModel($db);

// Instantiate Controllers
$homeController = new HomeController($playlistModel);
$userController = new UserController($userModel);

// Simple Routing
$action = $_GET['action'] ?? 'home'; // Default to 'home' if no action is specified

switch ($action) {
    case 'home':
        $homeController->index();
        break;
    case 'register':
        $userController->register();
        break;
    case 'login':
        $userController->login();
        break;
    default:
        echo "404 - Page not found";
        break;
}