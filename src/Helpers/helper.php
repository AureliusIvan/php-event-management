<?php
// Helper function to sanitize inputs and prevent XSS
function sanitize($data): string
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

