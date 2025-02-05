<?php
abstract class User {
    protected $db;
    protected $id;
    protected $username;
    protected $role_id;

    public function __construct($db, $id, $username, $role_id) {
        $this->db = $db;
        $this->id = $id;
        $this->username = $username;
        $this->role_id = $role_id;
    }

    // Common methods for all users
    abstract public function getProfile();
    abstract public function logout();

    // Fetch liked songs (common for Utilisateur and Artist)
    public function getLikedSongs() {
        $query = "SELECT s.* FROM Songs s 
                  JOIN LikedSongs ls ON s.id = ls.song_id 
                  WHERE ls.user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch playlists (common for Utilisateur and Artist)
    public function getPlaylists() {
        $query = "SELECT * FROM Playlists WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}