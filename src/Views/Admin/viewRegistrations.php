<?php
//session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require_once '../../../config/db.php';
require_once '../../../src/controllers/registrationController.php';

$registrations = getRegistrations($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registrations</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
<h1>Event Registrations</h1>

<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Event</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($registrations as $registration): ?>
        <tr>
            <td><?php echo htmlspecialchars($registration['name']); ?></td>
            <td><?php echo htmlspecialchars($registration['email']); ?></td>
            <td><?php echo htmlspecialchars($registration['event']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<p><a href="dashboard.php">Back to Dashboard</a></p>
</body>
</html>