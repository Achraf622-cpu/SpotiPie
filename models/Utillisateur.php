<?php
// models/Utilisateur.php
class Utilisateur extends User {
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
}