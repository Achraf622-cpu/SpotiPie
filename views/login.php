<!-- views/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">
    <div class="flex justify-center items-center h-screen">
        <form method="POST" action="index.php?action=login" class="bg-gray-800 p-8 rounded-lg">
            <h2 class="text-2xl font-bold mb-4">Login</h2>
            <input type="text" name="username" placeholder="Username" class="w-full p-2 mb-4 bg-gray-700 rounded">
            <input type="password" name="password" placeholder="Password" class="w-full p-2 mb-4 bg-gray-700 rounded">
            <button type="submit" class="w-full bg-green-500 p-2 rounded">Login</button>
            <p class="mt-4 text-center">
                Don't have an account? <a href="index.php?action=register" class="text-green-500">Register</a>
            </p>
        </form>
    </div>
</body>
</html>