<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="container mx-auto mt-8 p-6 bg-white rounded-lg shadow-lg">
    <?php if (isset($message) && !empty($message)): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p><?= $message ?></p>
        </div>
    <?php endif; ?>

    <?php if ($event): ?>
        <h1 class="text-3xl font-bold mb-4"><?= htmlspecialchars($event['name']) ?></h1>

        <p class="text-gray-600">
            <strong>Date:</strong> <?= htmlspecialchars($event['date']) ?>
        </p>
        <p class="text-gray-600">
            <strong>Location:</strong> <?= htmlspecialchars($event['location']) ?>
        </p>

        <div class="mt-4">
            <h2 class="text-2xl font-semibold mb-2">Event Description</h2>
            <p class="text-gray-700"><?= htmlspecialchars($event['description']) ?></p>
        </div>


        <?php if ($event['is_registered']): ?>
            <p class="text-green-500 mt-4">You're already registered for this event.</p>
            <form action="event-cancellation" method="post" onsubmit="return confirmCancellation();">
                <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                <input type="hidden" name="cancel_registration" value="1">
                <button type="submit"
                        class="mt-6 inline-block bg-red-500 hover:bg-red-300 text-white py-2 px-4 rounded">
                    Cancel Registration
                </button>
            </form>
        <?php else: ?>

            <form action="event-registration" method="post">
                <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                <button type="submit"
                        class="mt-6 inline-block bg-green-300 hover:bg-green-500 text-white py-2 px-4 rounded">
                    Register
                </button>
            </form>
        <?php endif; ?>

        <!-- Back to Events List Button -->
        <a href="event-list" class="mt-6 inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
            Back to Events List
        </a>

    <?php else: ?>
        <h1 class="text-3xl font-bold text-red-500">Event Not Found</h1>
        <p class="text-gray-600">The event you're looking for doesn't exist or the ID is invalid.</p>

        <!-- Back to Events List Button -->
        <a href="event-list" class="mt-6 inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
            Back to Events List
        </a>
    <?php endif; ?>

</div>

<script>
  function confirmCancellation() {
    return confirm("Are you sure you want to cancel your registration for this event?");
  }
</script>
</body>
</html>
