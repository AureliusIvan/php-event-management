<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-6">
    <!-- Dashboard Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
        <p class="text-gray-700">Manage events and user registrations.</p>
    </div>

    <!-- Overview Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- Total Events -->
        <div class="bg-white p-4 rounded shadow-sm">
            <h2 class="text-xl font-semibold">Total Events</h2>
            <p class="text-2xl font-bold">
                <?php echo $data['total_events']; ?>
            </p>
        </div>
        <!-- Total Users -->
        <div class="bg-white p-4 rounded shadow-sm">
            <h2 class="text-xl font-semibold">Total Users</h2>
            <p class="text-2xl font-bold">
                <?php echo $data['total_users']; ?>
            </p>
        </div>
        <!-- Registrations Overview -->
        <div class="bg-white p-4 rounded shadow-sm">
            <h2 class="text-xl font-semibold">Registrations</h2>
            <p class="text-2xl font-bold">
                <?php echo $data['total_transactions']; ?>
            </p>
        </div>
    </div>

    <!-- Event Management Section -->
    <div class="bg-white p-6 rounded shadow-sm mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Event Management</h2>
            <a href="/admin/add-new-event" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add New Event
            </a>

        </div>
        <table class="min-w-full bg-white">
            <thead>
            <tr class="w-full bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Event</th>
                <th class="py-3 px-6 text-left">Date</th>
                <th class="py-3 px-6 text-center">Participants</th>
                <th class="py-3 px-6 text-center">Actions</th>
            </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
            <?php foreach ($data['events'] as $event): ?>

                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">
                        <?= htmlspecialchars($event['name']) ?>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <?= htmlspecialchars($event['date']) ?>
                    </td>
                    <td class="py-3 px-6 text-center">
                        0
                    </td>
                    <td class="py-3 px-6 text-center">
                        <button class="bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600">Edit</button>
                        <button class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <!-- Add more events as needed -->
            </tbody>
        </table>
    </div>

    <!-- User Management Section -->
    <div class="bg-white p-6 rounded shadow-sm mb-6">
        <h2 class="text-2xl font-semibold mb-4">User Management</h2>
        <table class="min-w-full bg-white">
            <thead>
            <tr class="w-full bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Name</th>
                <th class="py-3 px-6 text-left">Email</th>
                <th class="py-3 px-6 text-center">Events Registered</th>
                <th class="py-3 px-6 text-center">Actions</th>
            </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
            <?php foreach ($data['users'] as $user): ?>
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">
                        <?= htmlspecialchars($user['name']) ?>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <?= htmlspecialchars($user['email']) ?>
                    </td>
                    <td class="py-3 px-6 text-center">
                        0
                    </td>
                    <td class="py-3 px-6 text-center">
                        <button class="bg-yellow-500 text-white px-4 py-1 rounded hover:bg-yellow-600">Edit</button>
                        <button class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
            <!-- Add more users as needed -->
            </tbody>
        </table>
    </div>

    <!-- Registration Export -->
    <div class="bg-white p-6 rounded shadow-sm">
        <h2 class="text-2xl font-semibold mb-4">Export Registrations</h2>
        <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Export to CSV</button>
    </div>
</div>
</body>
</html>
