<?php

class UserController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Handle user login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM Users WHERE username = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = $user;

                // Redirect based on role
                switch ($user['role_id']) {
                    case 1: // Utilisateur
                        header("Location: index.php?action=profile");
                        break;
                    case 2: // Artist
                        header("Location: index.php?action=artist_profile");
                        break;
                    case 3: // Admin
                        header("Location: index.php?action=admin_profile");
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
        if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 3) { // Role ID 3 = Admin
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
}