<?php
class HomeController {
    private $playlistModel;

    public function __construct($playlistModel) {
        $this->playlistModel = $playlistModel;
    }

    // Display the home page
    public function index() {
        // Fetch playlists from the Model
        $playlists = $this->playlistModel->getPlaylists();

        // Load the View and pass data to it
        include 'views/home.php';
    }
}