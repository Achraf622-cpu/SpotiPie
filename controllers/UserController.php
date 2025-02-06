<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validate inputs
            if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
                echo "All fields are required.";
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid email format.";
                return;
            }

            if ($password !== $confirmPassword) {
                echo "Passwords do not match.";
                return;
            }

            // Check if username or email already exists
            $userModel = new UserModel($this->db); // Assuming UserModel handles db queries
            if ($userModel->checkIfExists($username, $email)) {
                echo "Username or Email already taken.";
                return;
            }

            // Register user
            if ($userModel->registerUser($username, $email, $password)) {
                $user = $userModel->findUserByUsername($username);
                session_start();
                $_SESSION['user'] = $user;
                header("Location: index.php?action=profile");
                exit();
            } else {
                echo "Registration failed. Please try again.";
            }
        } else {
            include 'views/register.php';
        }
    }
    
    // In UserController.php

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            // Check if username and password are provided
            if (empty($username) || empty($password)) {
                echo "All fields are required.";
                return;
            }

            // Use UserModel to find user by username
            $userModel = new UserModel($this->db);
            $user = $userModel->findUserByUsername($username);

            // Verify password
            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = $user; // Store user info in session

                // Role-based logic to instantiate the correct model
                switch ($user['role_id']) {
                    case 1: // Guest
                        // Instantiate Guest or basic User model
                        break;
                    case 2: // Utilisateur
                        $userModel = new Utilisateur($this->db, $user['id'], $user['username'], $user['role_id']);
                        break;
                    case 3: // Artist
                        $userModel = new Artist($this->db, $user['id'], $user['username'], $user['role_id']);
                    break;
                    case 4: // Admin
                        $userModel = new Admin($this->db, $user['id'], $user['username'], $user['role_id']);
                    break;
                    default:
                        echo "Invalid role.";
                        return;
            }

            // Redirect based on user role
            switch ($user['role_id']) {
                case 2: // Utilisateur
                    header("Location: index.php?action=profile");
                    break;
                case 3: // Artist
                    header("Location: index.php?action=artist_profile");
                    break;
                case 4: // Admin
                    header("Location: index.php?action=admin_profile");
                    break;
                default:
                    echo "Invalid role.";
                    break;
            }
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        include 'views/login.php';
    }
}

    
    
    // Handle admin profile
    public function adminProfile() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 4) { // Role ID 4 = Admin
            header("Location: index.php?action=login");
            exit();
        }

        $admin = new Admin($this->db, $_SESSION['user']['id'], $_SESSION['user']['username'], $_SESSION['user']['role_id']);
        $users = $admin->getAllUsers();
        $songs = $admin->getAllSongs();
        $albums = $admin->getAllAlbums();
        $categories = $admin->getAllCategories();

        include 'views/admin_profile.php';
    }

    public function artistProfile() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 3) { // Role ID 3 = Artist
            header("Location: index.php?action=login");
            exit();
        }

        $artist = new Artist($this->db, $_SESSION['user']['id'], $_SESSION['user']['username'], $_SESSION['user']['role_id']);
        $profile = $artist->getProfile();
        include 'views/artist_profile.php';
    }

    // Handle banning a user
    public function banUser() {
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];
            $admin = new Admin($this->db, $_SESSION['user']['id'], $_SESSION['user']['username'], $_SESSION['user']['role_id']);
            if ($admin->banUser($userId)) {
                header("Location: index.php?action=manage_users");
                exit();
            } else {
                echo "Failed to ban user.";
            }
        }
    }

    // Handle adding a category
    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $admin = new Admin($this->db, $_SESSION['user']['id'], $_SESSION['user']['username'], $_SESSION['user']['role_id']);
            if ($admin->addCategory($name)) {
                header("Location: index.php?action=manage_categories");
                exit();
            } else {
                echo "Failed to add category.";
            }
        }
    }

    // Handle deleting a category
    public function deleteCategory() {
        if (isset($_GET['id'])) {
            $categoryId = $_GET['id'];
            $admin = new Admin($this->db, $_SESSION['user']['id'], $_SESSION['user']['username'], $_SESSION['user']['role_id']);
            if ($admin->deleteCategory($categoryId)) {
                header("Location: index.php?action=manage_categories");
                exit();
            } else {
                echo "Failed to delete category.";
            }
        }
    }
    public function logout() {
        session_start();
        session_unset(); 
        session_destroy(); 
        header("Location: index.php?action=home"); 
        exit();
    }
    
}