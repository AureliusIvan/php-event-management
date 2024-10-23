<?php


namespace App\Middleware;

class AuthMiddleware
{
    /**
     * List of public routes that don't require authentication
     */
    private array $publicRoutes = [
        '/login',
        '/user-login',
        '/register',
        '/create-user',
        '/forgot-password',
        '/reset-password',
        // Add other public routes as needed
    ];

    /**
     * List of routes that require admin role
     */
    private array $adminRoutes = [
        '/admin',
        '/admin/*',
        '/settings',
        // Add other admin routes as needed
    ];

    /**
     * Initialize the middleware
     */
    public function __construct()
    {
        $this->startSession();
        $this->handleAuthentication();
    }

    /**
     * Start the session if not already started
     */
    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Handle authentication and authorization
     */
    private function handleAuthentication(): void
    {
        $currentRoute = $_SERVER['REQUEST_URI'];

        // Allow access to public routes
        if ($this->isPublicRoute($currentRoute)) {
            return;
        }

        // Check if user is authenticated
        if (!$this->isAuthenticated()) {
            $this->redirectToLogin();
        }

        // Check if route requires admin privileges
        if ($this->isAdminRoute($currentRoute) && !$this->isAdmin()) {
            $this->handleUnauthorized();
        }
    }

    /**
     * Check if the current route is public
     */
    private function isPublicRoute(string $route): bool
    {
        return in_array($route, $this->publicRoutes);
    }

    /**
     * Check if the current route requires admin privileges
     */
    private function isAdminRoute(string $route): bool
    {
        foreach ($this->adminRoutes as $adminRoute) {
            // Handle wildcard routes
            if (str_ends_with($adminRoute, '/*')) {
                $prefix = rtrim($adminRoute, '/*');
                if (str_starts_with($route, $prefix)) {
                    return true;
                }
            }
            // Exact match
            if ($route === $adminRoute) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user is authenticated
     */
    private function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Check if user has admin role
     */
    private function isAdmin(): bool
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    /**
     * Redirect to login page
     */
    private function redirectToLogin(): never
    {
        // Store the intended destination URL in the session
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];

        header('Location: /login');
        exit;
    }

    /**
     * Handle unauthorized access
     */
    private function handleUnauthorized(): never
    {
        header('HTTP/1.1 403 Forbidden');
        // You can redirect to a custom error page
        header('Location: /unauthorized');
        exit;
    }
}
