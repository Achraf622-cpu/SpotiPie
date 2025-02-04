<?php
class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Register a new user
    public function register($username, $email, $password, $role_id) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO Users (username, email, password, role_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$username, $email, $hashedPassword, $role_id]);
    }

    // Login a user
    public function login($username, $password) {
        $query = "SELECT * FROM Users WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Return user data if login is successful
        }
        return false; // Return false if login fails
    }
    
    // Fetch liked songs for a user
    public function getLikedSongs($userId) {
        $query = "SELECT s.* FROM Songs s 
                  JOIN LikedSongs ls ON s.id = ls.song_id 
                  WHERE ls.user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch playlists for a user
    public function getPlaylists($userId) {
        $query = "SELECT * FROM Playlists WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}