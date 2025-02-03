<?php
class PlaylistModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function getPlaylists() {
        $query = "SELECT * FROM playlists";
        $result = $this->db->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPlaylistById($id) {
        $query = "SELECT * FROM playlists WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}