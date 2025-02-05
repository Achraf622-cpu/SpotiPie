<?php
// models/Admin.php
class Admin extends User {
    // Add a new category
    public function addCategory($name) {
        $query = "INSERT INTO Categories (name) VALUES (?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$name]);
    }

    // Ban a user
    public function banUser($userId) {
        $query = "UPDATE Users SET is_banned = TRUE WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$userId]);
    }

    public function getProfile() {
        $likedSongs = $this->getLikedSongs();
        $playlists = $this->getPlaylists();
        return [
            'likedSongs' => $likedSongs,
            'playlists' => $playlists
        ];
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?action=home");
        exit();
    }
     // Fetch all users
     public function getAllUsers() {
        $query = "SELECT * FROM Users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all songs
    public function getAllSongs() {
        $query = "SELECT * FROM Songs";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all albums
    public function getAllAlbums() {
        $query = "SELECT * FROM Albums";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all categories
    public function getAllCategories() {
        $query = "SELECT * FROM Categories";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Delete a category
    public function deleteCategory($categoryId) {
        $query = "DELETE FROM Categories WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$categoryId]);
    }
}