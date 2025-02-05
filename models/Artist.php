<?php
// models/Artist.php
class Artist extends User {
    // Upload a new song
    public function uploadSong($title, $filePath, $duration, $categoryId) {
        $query = "INSERT INTO Songs (title, file_path, duration, artist_id, category_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$title, $filePath, $duration, $this->id, $categoryId]);
    }

    // Create a new album
    public function createAlbum($name, $categoryId) {
        $query = "INSERT INTO Albums (name, artist_id, category_id) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$name, $this->id, $categoryId]);
    }

    // Fetch uploaded songs
    public function getUploadedSongs() {
        $query = "SELECT * FROM Songs WHERE artist_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch created albums
    public function getAlbums() {
        $query = "SELECT * FROM Albums WHERE artist_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProfile() {
        $likedSongs = $this->getLikedSongs();
        $playlists = $this->getPlaylists();
        $uploadedSongs = $this->getUploadedSongs();
        $albums = $this->getAlbums();
        return [
            'likedSongs' => $likedSongs,
            'playlists' => $playlists,
            'uploadedSongs' => $uploadedSongs,
            'albums' => $albums
        ];
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?action=home");
        exit();
    }
}