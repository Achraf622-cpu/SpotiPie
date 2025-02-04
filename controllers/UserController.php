<?php
class UserController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role_id = 2;

            if ($this->userModel->register($username, $email, $password, $role_id)) {
                echo "Registration successful!";
            } else {
                echo "Registration failed.";
            }
        } else {
            include 'views/register.php';
        }
    }
    // Handle user login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);
            if ($user) {
                // Start a session and store user data
                session_start();
                $_SESSION['user'] = $user;
                echo "Login successful! Welcome, " . $user['username'];
            } else {
                echo "Invalid username or password.";
            }
        } else {
            include 'views/login.php';
        }
    }
    // Handle profile page
    public function profile() {
        session_start();
        if (!isset($_SESSION['user'])) {
            // Redirect to login if user is not logged in
            header("Location: index.php?action=login");
            exit();
        }

        $userId = $_SESSION['user']['id'];
        $likedSongs = $this->userModel->getLikedSongs($userId);
        $playlists = $this->userModel->getPlaylists($userId);

        include 'views/profile.php';
    }
}