<?php
// index.php
session_start(); // Start the session

// Database connection
$db = new PDO('mysql:host=localhost;dbname=spotify_clone', 'root', 'password');

// Include Models
require 'models/User.php';
require 'models/Utilisateur.php';
require 'models/Artist.php';
require 'models/Admin.php';

// Include Controllers
require 'controllers/UserController.php';

// Instantiate Controllers
$userController = new UserController($db);

// Simple Routing
$action = $_GET['action'] ?? 'home'; // Default to 'home' if no action is specified

switch ($action) {
    case 'home':
        include 'views/home.php';
        break;
    case 'login':
        $userController->login();
        break;
    case 'admin_profile':
        $userController->adminProfile();
        break;
    case 'ban_user':
        $userController->banUser();
        break;
    case 'add_category':
        $userController->addCategory();
        break;
    case 'delete_category':
        $userController->deleteCategory();
        break;
    default:
        echo "404 - Page not found";
        break;
}