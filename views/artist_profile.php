<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Profile</title>
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
                <li><a href="index.php?action=artist_profile" class="flex items-center space-x-3 hover:text-white">
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

            <!-- Upload Song Form -->
            <div class="mb-8">
                <h3 class="text-xl font-bold mb-4">Upload New Song</h3>
                <form method="POST" action="index.php?action=upload_song" enctype="multipart/form-data" class="bg-gray-700 p-4 rounded-lg">
                    <!-- Song Title -->
                    <input type="text" name="title" placeholder="Song Title" class="w-full p-2 mb-4 bg-gray-600 rounded">
                    
                    <!-- Song File -->
                    <input type="file" name="file" class="w-full p-2 mb-4 bg-gray-600 rounded">
                    
                    <!-- Album Selection -->
                    <select name="album_id" class="w-full p-2 mb-4 bg-gray-600 rounded">
                        <option value="">Select Album</option>
                        <?php foreach ($albums as $album): ?>
                            <option value="<?= $album['id'] ?>"><?= $album['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    
                    <!-- Category Selection -->
                    <select name="category_id" class="w-full p-2 mb-4 bg-gray-600 rounded">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Song Image -->
                    <input type="file" name="image" accept="image/*" class="w-full p-2 mb-4 bg-gray-600 rounded">
                    
                    <!-- Duration -->
                    <input type="number" name="duration" placeholder="Duration (in seconds)" class="w-full p-2 mb-4 bg-gray-600 rounded">

                    <button type="submit" class="w-full bg-green-500 p-2 rounded">Upload Song</button>
                </form>
            </div>

            <!-- Uploaded Songs -->
            <div class="mb-8">
                <h3 class="text-xl font-bold mb-4">Your Songs</h3>
                <div class="grid grid-cols-3 gap-4">
                    <?php if (!empty($uploadedSongs)): ?>
                        <?php foreach ($uploadedSongs as $song): ?>
                            <div class="bg-gray-700 p-4 rounded-lg">
                                <img src="<?= $song['image_url'] ?>" alt="Song" class="w-full rounded-lg">
                                <div class="mt-2 font-bold"><?= $song['title'] ?></div>
                                <div class="text-sm text-gray-400"><?= $song['artist_name'] ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-gray-400">No songs uploaded yet.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
