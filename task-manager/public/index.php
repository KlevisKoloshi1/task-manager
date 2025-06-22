<?php
// Include configuration
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/Controllers/TaskController.php';

// Parse the URL
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);

// Remove the base path (adjust this based on your setup)
$basePath = '/task-manager/public/index.php';
$route = str_replace($basePath, '', $path);

// Remove leading slash
$route = ltrim($route, '/');

// Split the route into parts
$routeParts = explode('/', $route);

// Initialize controller
$controller = new TaskController();

// Route the request
if (empty($route) || $route === '') {
    // Default route - show all tasks
    $controller->index();
} elseif ($routeParts[0] === 'task') {
    switch ($routeParts[1] ?? '') {
        case 'create':
            $controller->create();
            break;
            
        case 'store':
            $controller->store();
            break;
            
        case 'edit':
            if (isset($routeParts[2]) && is_numeric($routeParts[2])) {
                $controller->edit($routeParts[2]);
            } else {
                header('Location: ' . BASE_URL);
                exit;
            }
            break;
            
        case 'update':
            if (isset($routeParts[2]) && is_numeric($routeParts[2])) {
                $controller->update($routeParts[2]);
            } else {
                header('Location: ' . BASE_URL);
                exit;
            }
            break;
            
        case 'delete':
            if (isset($routeParts[2]) && is_numeric($routeParts[2])) {
                $controller->delete($routeParts[2]);
            } else {
                header('Location: ' . BASE_URL);
                exit;
            }
            break;
            
        default:
            // Invalid route
            header('HTTP/1.0 404 Not Found');
            echo '404 - Page Not Found';
            break;
    }
} else {
    // Invalid route
    header('HTTP/1.0 404 Not Found');
    echo '404 - Page Not Found';
}
?>