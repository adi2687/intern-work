<?php

class Router
{
    public $request;
    public $queries;
    public $routes = [];

    public function __construct(array $request)
    {
        $this->request = trim($request['REQUEST_URI'], '/'); // Remove the leading slash
    
        // Debugging: Print the original request URI
    
        // Check if the URI contains a query string
        if (strpos($this->request, '?') !== false) {
            $queryString = explode("?", $this->request)[1];
            $this->queries = explode("&", $queryString);
        } else {
            $this->queries = [];
        }
    
        // Load and validate routes.json    
        $this->routes = [];
        $jsonPath = __DIR__ . '/router.json';
    
        if (file_exists($jsonPath)) {
            $jsonContent = file_get_contents($jsonPath);
            $this->routes = json_decode($jsonContent, true);
    
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Handle invalid JSON
                echo "Error loading routes: " . json_last_error_msg();
                exit;
            }
        } else {
            echo "Routes file not found!";
            exit;
        }
    }
    
public function run()
{
    require_once('config.php');

    // If the request is empty, serve the home page
    if (empty($this->request)) {
        include($this->routes['intern-work']['path']);
        return;
    }

    // Route matching from JSON configuration
    $routeFound = false;
    foreach ($this->routes as $route => $data) {
        if ($route === $this->request) {
            include($data['path']);
            $routeFound = true;
            break;
        }
    }

    // Handle 404 if no route is found
    if (!$routeFound) {
        $this->pageNotFound();
    }
}

    
    // Create a regular expression pattern for the route
    private function getPattern($route)
    {
        $pattern = str_replace('/', '\/', $route);
        $pattern = preg_replace('/{([\w@+.-_]+)}/', '(?P<$1>[\w@.-]+)', $pattern);
        return '/^' . $pattern . '$/';
    }

    // Set variables from the route parameters
    private function setRouteVariables(&$data, $matches)
    {
        foreach ($matches as $key => $value) {
            if (is_string($key) && !empty($value)) {
                $_REQUEST[$key] = $value;
            }
        }
    }

    // Handle 404 error
    private function pageNotFound()
    {
        header("HTTP/1.1 404 Not Found");
        include('views/404.php'); // Show custom 404 page
    }
}
