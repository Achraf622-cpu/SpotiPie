<?php

class MusicModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Fetch all songs uploaded by the artist
    public function getUploadedSongs($artistId) {
        $query = "SELECT * FROM Songs WHERE artist_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$artistId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all albums created by the artist
    public function getAlbums($artistId) {
        $query = "SELECT * FROM Albums WHERE artist_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$artistId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all music categories (for song categorization)
    public function getCategories() {
        $query = "SELECT * FROM Categories";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert a new song into the database
    public function uploadSong($title, $filePath, $duration, $categoryId, $albumId, $imagePath) {
        // Ensure all fields are validated properly
        // If category_id or album_id are optional, default them to NULL if empty
        $categoryId = !empty($categoryId) ? (int)$categoryId : NULL;
        $albumId = !empty($albumId) ? (int)$albumId : NULL;
    
        // Insert song into the database
        $query = "INSERT INTO Songs (title, file_path, duration, artist_id, category_id, album_id, image_url) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$title, $filePath, $duration, $_SESSION['user']['id'], $categoryId, $albumId, $imagePath]);
    }
    
}
