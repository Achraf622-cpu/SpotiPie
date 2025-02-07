<?php
session_start(); // Start the session

// Load database connection
require_once 'config.php';

// Include Models
require_once 'models/UserModel.php'; // This should handle all user-related queries
require_once 'models/Utilisateur.php';
require_once 'models/Artist.php';
require_once 'models/Admin.php';
require_once 'models/MusicModel.php';
require_once 'controllers/MusicController.php';

// Include Controllers
require_once 'controllers/UserController.php';

// Instantiate Models
$userModel = new UserModel($db); 

// Instantiate Controllers
$userController = new UserController($db);

// Instantiate the MusicController
$musicController = new MusicController($db);

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
    case 'artist_profile':  // Add a new case for artist profile
        $userController->artistProfile(); // This will call the method in the controller
        break;
        case 'upload_song':
            $musicController->uploadSong();
            break;
    default:
        header("HTTP/1.0 404 Not Found");
        include 'views/404.php'; // Make sure you have a proper 404 page
        break;
}
?>
