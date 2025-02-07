<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 p-5">
            <div class="text-2xl font-bold mb-5">Spotify</div>
            <ul class="space-y-2">
                <li><a href="index.php?action=home" class="flex items-center space-x-3 hover:text-white">
                    <span>Home</span>
                </a></li>
                <li><a href="index.php?action=profile" class="flex items-center space-x-3 hover:text-white">
                    <span>Profile</span>
                </a></li>
                <li><a href="index.php?action=logout" class="flex items-center space-x-3 hover:text-white">
                    <span>Logout</span>
                </a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 bg-gray-800 p-5">
            <div class="text-2xl font-bold mb-5">Welcome, <?= $_SESSION['user']['username'] ?></div>

            <!-- Liked Songs -->
            <div class="mb-8">
                <h3 class="text-xl font-bold mb-4">Liked Songs</h3>
                <div class="grid grid-cols-3 gap-4">
                    <?php if (!empty($likedSongs)): ?>
                        <?php foreach ($likedSongs as $song): ?>
                            <div class="bg-gray-700 p-4 rounded-lg">
                                <img src="https://via.placeholder.com/150" alt="Song" class="w-full rounded-lg">
                                <div class="mt-2 font-bold"><?= $song['title'] ?></div>
                                <div class="text-sm text-gray-400"><?= $song['artist'] ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-gray-400">No liked songs found.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Playlists -->
            <div>
                <h3 class="text-xl font-bold mb-4">Your Playlists</h3>
                <div class="grid grid-cols-3 gap-4">
                    <?php if (!empty($playlists)): ?>
                        <?php foreach ($playlists as $playlist): ?>
                            <div class="bg-gray-700 p-4 rounded-lg">
                                <img src="https://via.placeholder.com/150" alt="Playlist" class="w-full rounded-lg">
                                <div class="mt-2 font-bold"><?= $playlist['name'] ?></div>
                                <div class="text-sm text-gray-400"><?= $playlist['description'] ?? 'No description' ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-gray-400">No playlists found.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>