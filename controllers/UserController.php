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
}