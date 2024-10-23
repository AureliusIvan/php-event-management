<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6">
        Add New Event
    </h2>

    <?php if (isset($error)): ?>
        <p class="text-red-500"><?= $error ?></p>
    <?php elseif (isset($_SESSION['success'])): ?>
        <p class="text-green-500"><?= $_SESSION['success'];
            unset($_SESSION['success']); ?></p>
    <?php endif; ?>

    <form action="/add-new-event" method="POST">
        <div class="mb-4">
            <label for="profile_image" class="block text-sm font-medium">
                Profile Image
            </label>
            <input
                    type="file"
                    name="profile_image"
                    id="profile_image"
                    class="mt-1 block w-full p-2 border rounded"
            >
        </div>
        <div class="mb-4">
            <label
                    for="name"
                    class="block text-sm font-medium"
            >
                Event Name
            </label>
            <input
                    type="text"
                    name="name"
                    id="name"
                    placeholder="Event Name"
                    class="mt-1 block w-full p-2 border rounded"
                    required>
        </div>

        <div class="mb-4">
            <label for="date" class="block text-sm font-medium">
                Date
            </label>
            <input type="date"
                   name="date"
                   id="date"
                   class="mt-1 block w-full p-2 border rounded"
                   required
            >
        </div>

        <div class="mb-4">
            <label for="location" class="block text-sm font-medium">
                Location
            </label>
            <input
                    type="text"
                    name="location"
                    id="location"
                    placeholder="City, State"
                    class="mt-1 block w-full p-2 border rounded"
                    required
            >

        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Add New Event
        </button>

    </form>
</div>
</body>
</html>