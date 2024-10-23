<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6">Edit Profile</h2>

    <?php if (isset($error)): ?>
        <p class="text-red-500"><?= $error ?></p>
    <?php elseif (isset($_SESSION['success'])): ?>
        <p class="text-green-500"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></p>
    <?php endif; ?>

    <form action="/update-profile" method="POST">
        <div class="mb-4">
            <label for="profile_image" class="block text-sm font-medium">Profile Image</label>
            <input type="file" name="profile_image" id="profile_image" class="mt-1 block w-full p-2 border rounded">
        </div>
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium">Name</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>"
                   class="mt-1 block w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>"
                   class="mt-1 block w-full p-2 border rounded" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium">New Password</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full p-2 border rounded" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Update Profile
        </button>
    </form>
</div>
</body>
</html>