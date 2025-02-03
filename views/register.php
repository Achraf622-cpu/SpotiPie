<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">
    <div class="flex justify-center items-center h-screen">
        <form method="POST" class="bg-gray-800 p-8 rounded-lg">
            <h2 class="text-2xl font-bold mb-4">Register</h2>
            <input type="text" name="username" placeholder="Username" class="w-full p-2 mb-4 bg-gray-700 rounded">
            <input type="email" name="email" placeholder="Email" class="w-full p-2 mb-4 bg-gray-700 rounded">
            <input type="password" name="password" placeholder="Password" class="w-full p-2 mb-4 bg-gray-700 rounded">
            <button type="submit" class="w-full bg-green-500 p-2 rounded">Register</button>
        </form>
    </div>
</body>
</html>