<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- Main container -->
<div class="container mx-auto mt-8 p-6 bg-white rounded-lg shadow-lg p-t-[20px]">

    <!--  toast  -->
    <?php if (isset($message) && !empty($message)): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p><?= $message ?></p>
        </div>
    <?php endif; ?>

    <h1 class="text-2xl font-bold text-center mb-6">
        Your Registered Events
    </h1>

    <!-- Event List -->
    <ul class="space-y-4">
        <?php if (isset($events) && is_array($events) && count($events) > 0): ?>
            <?php foreach ($events as $event): ?>
                <li class="bg-blue-100 border-l-4 border-blue-500 p-4 rounded-lg shadow flex items-center justify-between">
                    <!-- Event Image (Placeholder) -->
                    <img class="w-16 h-16 object-cover rounded-full mr-4" src="https://picsum.photos/200/300"
                         alt="Event Image">

                    <!-- Event Details -->
                    <div class="flex-1">
                        <span class="block text-lg font-semibold text-gray-700">
                            <?= htmlspecialchars(isset($event['name']) ? $event['name'] : 'Unknown Event') ?>
                        </span>
                        <span class="text-gray-600">
                            <?= htmlspecialchars(isset($event['date']) ? $event['date'] : 'Unknown Date') ?>
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <!-- Detail Button -->
                        <a href="event-details?id=<?= htmlspecialchars($event['id']) ?>"
                           class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">
                            Detail
                        </a>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="text-gray-500 text-center">No events available at the moment.</li>
        <?php endif; ?>
    </ul>
</div>

</body>
</html>
