

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 p-5">
            <div class="text-2xl font-bold mb-5">SpotiPie</div>
                <ul class="space-y-2">
                    <li><a href="index.php?action=home" class="flex items-center space-x-3 hover:text-white">
                          <span>Home</span>
                      </a></li>

                    <?php if (!isset($_SESSION['user'])): ?> <!-- Check if the user is logged in -->
                        <li><a href="index.php?action=register" class="flex items-center space-x-3 hover:text-white">
                            <span>Register</span>
                        </a></li>
                        <li><a href="index.php?action=login" class="flex items-center space-x-3 hover:text-white">
                            <span>Login</span>
                        </a></li>
                    <?php else: ?> <!-- If logged in, show profile link and hide register/login -->
                        <li><a href="index.php?action=profile" class="flex items-center space-x-3 hover:text-white">
                            <span>Profile</span>
                        </a></li>
                        <!-- Optionally, you can also add a logout link -->
                        <li><a href="index.php?action=logout" class="flex items-center space-x-3 hover:text-white">
                            <span>Logout</span>
                        </a></li>
                    <?php endif; ?>
                </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 bg-gray-800 p-5">
            <div class="text-2xl font-bold mb-5">Playlists</div>
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

    <!-- Player Bar -->
    <div class="fixed bottom-0 left-0 right-0 bg-gray-900 p-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="https://via.placeholder.com/50" alt="Song" class="w-12 h-12 rounded-lg">
                <div>
                    <div class="font-bold">Song Title</div>
                    <div class="text-sm text-gray-400">Artist</div>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <button class="text-white">Previous</button>
                <button class="text-white">Play</button>
                <button class="text-white">Next</button>
            </div>
            <div class="flex items-center space-x-4">
                <input type="range" class="w-32" />
                <span class="text-sm text-gray-400">0:00 / 3:00</span>
            </div>
        </div>
    </div>
</body>
</html>
