CREATE DATABASE spotify_clone;
USE spotify_clone;

-- Table: Users
CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES Roles(id)
);

-- Table: Roles
CREATE TABLE Roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Insert default roles
INSERT INTO Roles (name) VALUES
('guest'),
('user'),
('artist'),
('admin');

-- Table: Songs
CREATE TABLE Songs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    artist_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    duration INT NOT NULL, -- Duration in seconds
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (artist_id) REFERENCES Users(id)
);

-- Table: Playlists
CREATE TABLE Playlists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    user_id INT NOT NULL,
    is_public BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

-- Table: PlaylistSongs (Many-to-Many Relationship)
CREATE TABLE PlaylistSongs (
    playlist_id INT NOT NULL,
    song_id INT NOT NULL,
    PRIMARY KEY (playlist_id, song_id),
    FOREIGN KEY (playlist_id) REFERENCES Playlists(id),
    FOREIGN KEY (song_id) REFERENCES Songs(id)
);	

-- Table: LikedSongs
CREATE TABLE LikedSongs (
    user_id INT NOT NULL,
    song_id INT NOT NULL,
    PRIMARY KEY (user_id, song_id),
    FOREIGN KEY (user_id) REFERENCES Users(id),
    FOREIGN KEY (song_id) REFERENCES Songs(id)
);

-- Table: FollowedPlaylists
CREATE TABLE FollowedPlaylists (
    user_id INT NOT NULL,
    playlist_id INT NOT NULL,
    PRIMARY KEY (user_id, playlist_id),
    FOREIGN KEY (user_id) REFERENCES Users(id),
    FOREIGN KEY (playlist_id) REFERENCES Playlists(id)
);
CREATE TABLE Albums (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    artist_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (artist_id) REFERENCES Users(id)
);

CREATE TABLE Categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);
ALTER TABLE Users ADD COLUMN is_banned BOOLEAN DEFAULT FALSE;
ALTER TABLE Songs ADD COLUMN category_id INT;
ALTER TABLE Songs ADD FOREIGN KEY (category_id) REFERENCES Categories(id);
ALTER TABLE Songs ADD COLUMN album_id INT;
ALTER TABLE Songs ADD FOREIGN KEY (album_id) REFERENCES Albums(id);
ALTER TABLE Albums ADD COLUMN category_id INT;
ALTER TABLE Albums ADD FOREIGN KEY (category_id) REFERENCES Categories(id);

INSERT INTO Users (username, email, password, role_id) 
VALUES ('testuser', 'testuser@example.com', 'hashedpassword', 2);
-- Insert sample playlists
INSERT INTO Playlists (name, user_id, is_public) VALUES
('Chill Hits', 1, TRUE),
('Workout Beats', 1, TRUE),
('Study Focus', 1, TRUE);