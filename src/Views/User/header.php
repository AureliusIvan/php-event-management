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

<!-- Navigation Bar -->
<nav class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="text-white text-lg font-bold">My Event App</a>
        <ul class="flex space-x-4">
            <li>
                <a href="/" class="text-white hover:text-gray-200">
                    Events List
                </a>
            </li>
            <li>
                <a href="/event-registered-list" class="text-white hover:text-gray-200">
                    Registered Events
                </a>
            </li>
            <li>
                <a href="/logout" class="text-white hover:text-gray-200">
                    Logout
                </a>
            </li>
            <li>
                <a href="/profile" class="text-white hover:text-gray-200">
                    <img src="https://picsum.photos/200" class="w-8 h-8 rounded-full" alt="Profile Image">
                </a>
            </li>
        </ul>
    </div>
</nav>
