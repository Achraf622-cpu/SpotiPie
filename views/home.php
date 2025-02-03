<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpotiPie</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 p-5">
            <div class="text-2xl font-bold mb-5">SpotiPie</div>
            <ul class="space-y-2">
                <li><a href="#" class="flex items-center space-x-3 hover:text-white">
                    <span>Home</span>
                </a></li>
                <li><a href="#" class="flex items-center space-x-3 hover:text-white">
                    <span>Search</span>
                </a></li>
                <li><a href="#" class="flex items-center space-x-3 hover:text-white">
                    <span>Your Library</span>
                </a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 bg-gray-800 p-5">
            <div class="flex justify-between items-center mb-5">
                <div class="text-2xl font-bold">Home</div>
                <div class="flex space-x-4">
                    <button class="bg-white text-black px-4 py-2 rounded-full">Upgrade</button>
                    <button class="bg-gray-700 text-white px-4 py-2 rounded-full">Profile</button>
                </div>
            </div>

            <!-- Playlist Section -->
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-gray-700 p-4 rounded-lg">
                    <img src="https://via.placeholder.com/150" alt="Playlist" class="w-full rounded-lg">
                    <div class="mt-2 font-bold">Playlist 1</div>
                    <div class="text-sm text-gray-400">Description of playlist 1</div>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <img src="https://via.placeholder.com/150" alt="Playlist" class="w-full rounded-lg">
                    <div class="mt-2 font-bold">Playlist 2</div>
                    <div class="text-sm text-gray-400">Description of playlist 2</div>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <img src="https://via.placeholder.com/150" alt="Playlist" class="w-full rounded-lg">
                    <div class="mt-2 font-bold">Playlist 3</div>
                    <div class="text-sm text-gray-400">Description of playlist 3</div>
                </div>
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