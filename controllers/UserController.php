<?php

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
            $query = "SELECT * FROM Users WHERE username = ? OR email = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                echo "Username or Email already taken.";
                return;
            }
    
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
            // Default role_id = 2 (user)
            $roleId = 2;
    
            // Insert new user
            $insertQuery = "INSERT INTO Users (username, email, password, role_id) VALUES (?, ?, ?, ?)";
            $insertStmt = $this->db->prepare($insertQuery);
    
            if ($insertStmt->execute([$username, $email, $hashedPassword, $roleId])) {
                // Get the newly registered user
                $userId = $this->db->lastInsertId();
                $query = "SELECT * FROM Users WHERE id = ?";
                $stmt = $this->db->prepare($query);
                $stmt->execute([$userId]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
                // Start session and store user info
                session_start();
                $_SESSION['user'] = $user;
    
                // Redirect to profile page
                header("Location: index.php?action=profile");
                exit();
            } else {
                echo "Registration failed. Please try again.";
            }
        } else {
            include 'views/register.php';
        }
    }
    

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
    
            // Check if username and password are provided
            if (empty($username) || empty($password)) {
                echo "All fields are required.";
                return;
            }
    
            // Find user in the database
            $query = "SELECT * FROM Users WHERE username = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Verify password
            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = $user; // Store user info in session
    
                // Debugging line (remove after checking)
                // error_log('Redirecting to profile based on role');
    
                // Redirect based on the user role
                switch ($user['role_id']) {
                    case 1: // Guest
                        header("Location: index.php?action=profile");
                        break;
                    case 2: // User
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
    public function logout() {
        session_start();
        session_unset(); // Remove all session variables
        session_destroy(); // Destroy the session
        header("Location: index.php?action=home"); // Redirect to the home page after logging out
        exit();
    }
    
}