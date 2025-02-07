<?php
require_once __DIR__ . '/../config.php';

class UserModel {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Register a user
    public function registerUser($username, $email, $password, $roleId = 2) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO Users (username, email, password, role_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$username, $email, $hashedPassword, $roleId]);
    }

    // Check if username or email already exists
    public function checkIfExists($username, $email) {
        $query = "SELECT * FROM Users WHERE username = ? OR email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$username, $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Find a user by username
    public function findUserByUsername($username) {
        $query = "SELECT * FROM Users WHERE username = ?";
        $stmt = $this->db->prepare($query); // This line should work if $db is set correctly
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
