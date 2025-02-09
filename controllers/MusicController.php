<?php

class MusicController {
    private $db;
    private $musicModel;

    public function __construct($db) {
        $this->db = $db;
        $this->musicModel = new MusicModel($db);
    }

    // Display artist profile page (including uploaded songs, albums, etc.)
    public function artistProfile() {
        $artistId = $_SESSION['user']['id']; // Assuming user is logged in as an artist
        $uploadedSongs = $this->musicModel->getUploadedSongs($artistId);
        $albums = $this->musicModel->getAlbums($artistId);
        $categories = $this->musicModel->getCategories(); // Categories for songs
        include 'views/artist_profile.php';
    }

    // Handle the uploading of a song
    public function uploadSong() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $albumId = $_POST['album_id'] ?? null;
            $categoryId = $_POST['category_id'] ?? null;
            $duration = $_POST['duration'] ?? null;

            // Validate form data
            if (isset($_FILES['file']) && isset($_FILES['image'])) {
                // Handle file uploads (song file and image)
                $filePath = $this->uploadFile($_FILES['file'], 'songs');
                $imagePath = $this->uploadFile($_FILES['image'], 'images');

                // Store song in the database
                $this->musicModel->uploadSong($title, $filePath, $duration, $categoryId, $albumId, $imagePath);

                // Redirect to the artist profile page
                header("Location: index.php?action=artist_profile");
                exit();
            }
        }
    }

    public function uploadFile($file, $folder) {
        // Set the target directory for songs
        $targetDir = "assets/songs/"; // Changed this to the 'songs' folder
        $targetFile = $targetDir . basename($file['name']);
        
        // Make sure the folder exists
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
        }
    
        // Move the uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $targetFile; // Return the path of the uploaded file
        } else {
            // Handle error if file upload fails
            throw new Exception("Failed to upload the file.");
        }
    }
    
}
