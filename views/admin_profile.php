<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 p-5">
            <div class="text-2xl font-bold mb-5">Admin Dashboard</div>
            <ul class="space-y-2">
                <li><a href="index.php?action=admin_profile" class="flex items-center space-x-3 hover:text-white">
                    <span>Dashboard</span>
                </a></li>
                <li><a href="index.php?action=manage_users" class="flex items-center space-x-3 hover:text-white">
                    <span>Manage Users</span>
                </a></li>
                <li><a href="index.php?action=manage_categories" class="flex items-center space-x-3 hover:text-white">
                    <span>Manage Categories</span>
                </a></li>
                <li><a href="index.php?action=logout" class="flex items-center space-x-3 hover:text-white">
                    <span>Logout</span>
                </a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 bg-gray-800 p-5">
            <div class="text-2xl font-bold mb-5">Welcome, Admin</div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="bg-gray-700 p-4 rounded-lg">
                    <div class="text-lg font-bold">Total Users</div>
                    <div class="text-3xl"><?= $totalUsers ?></div>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <div class="text-lg font-bold">Total Songs</div>
                    <div class="text-3xl"><?= $totalSongs ?></div>
                </div>
                <div class="bg-gray-700 p-4 rounded-lg">
                    <div class="text-lg font-bold">Total Albums</div>
                    <div class="text-3xl"><?= $totalAlbums ?></div>
                </div>
            </div>

            <!-- Manage Users -->
            <div class="mb-8">
                <h3 class="text-xl font-bold mb-4">Manage Users</h3>
                <table class="w-full bg-gray-700 rounded-lg">
                    <thead>
                        <tr>
                            <th class="p-2">ID</th>
                            <th class="p-2">Username</th>
                            <th class="p-2">Email</th>
                            <th class="p-2">Role</th>
                            <th class="p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-gray-600">
                                <td class="p-2"><?= $user['id'] ?></td>
                                <td class="p-2"><?= $user['username'] ?></td>
                                <td class="p-2"><?= $user['email'] ?></td>
                                <td class="p-2"><?= $user['role_id'] == 1 ? 'User' : ($user['role_id'] == 2 ? 'Artist' : 'Admin') ?></td>
                                <td class="p-2">
                                    <?php if (!$user['is_banned']): ?>
                                        <a href="index.php?action=ban_user&id=<?= $user['id'] ?>" class="text-red-500">Ban</a>
                                    <?php else: ?>
                                        <span class="text-gray-400">Banned</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Manage Categories -->
            <div>
                <h3 class="text-xl font-bold mb-4">Manage Categories</h3>
                <form method="POST" action="index.php?action=add_category" class="mb-4">
                    <input type="text" name="name" placeholder="New Category Name" class="w-full p-2 mb-4 bg-gray-600 rounded">
                    <button type="submit" class="w-full bg-green-500 p-2 rounded">Add Category</button>
                </form>
                <table class="w-full bg-gray-700 rounded-lg">
                    <thead>
                        <tr>
                            <th class="p-2">ID</th>
                            <th class="p-2">Name</th>
                            <th class="p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr class="hover:bg-gray-600">
                                <td class="p-2"><?= $category['id'] ?></td>
                                <td class="p-2"><?= $category['name'] ?></td>
                                <td class="p-2">
                                    <a href="index.php?action=delete_category&id=<?= $category['id'] ?>" class="text-red-500">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>