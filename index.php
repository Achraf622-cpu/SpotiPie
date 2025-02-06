<?php
// index.php
session_start(); // Start the session
// Load database connection
require_once 'config.php';

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
    case 'register':
        $userController->register();
        break;
    case 'login':
        $userController->login();
        break;
    case 'profile':
        include 'views/profile.php';
        break;
    case 'admin_profile':
        $userController->adminProfile();
        break;
    case 'logout':
        $userController->logout();
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