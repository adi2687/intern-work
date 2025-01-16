<?php
/**
 * -----------------------------------------------------------------------------
 * Main Entry Point of GraphenePHP
 * -----------------------------------------------------------------------------
 *
 * This file serves as the main entry point for your GraphenePHP application.
 * It initializes the necessary components and sets up the routing system to
 * handle incoming requests.
 *
 * Author: Radhe Shyam Salopanthula
 * Version: 2.0.0
 *
 * -----------------------------------------------------------------------------
 */

session_start();

// -----------------------------------------------------------------------------
// Configuration & Setup
// -----------------------------------------------------------------------------

// Task 1: Check if config.php file exists, if not, copy config_example.php
if (!file_exists('config.php')) {
    require_once('setup.php');
    exit;

}

require_once('config.php');

// -----------------------------------------------------------------------------
// Headers
// -----------------------------------------------------------------------------
require_once('headers.php');

// -----------------------------------------------------------------------------
// Global Functions
// -----------------------------------------------------------------------------
require_once('functions.php');

// -----------------------------------------------------------------------------
// Disable Errors and Debugging
// -----------------------------------------------------------------------------
errors(0);

// -----------------------------------------------------------------------------
// AppController
// -----------------------------------------------------------------------------
controller('App');

// -----------------------------------------------------------------------------
// Database Class
// -----------------------------------------------------------------------------
require_once('models/db.php');

// -----------------------------------------------------------------------------
// Validator Class
// -----------------------------------------------------------------------------
require_once('models/validator.php');

// -----------------------------------------------------------------------------
// Database Migrator Class
// -----------------------------------------------------------------------------
require_once('models/migrator.php');

// -----------------------------------------------------------------------------
// Main Router
// -----------------------------------------------------------------------------
require_once('router.php');

date_default_timezone_set('Asia/Kolkata'); 

// -----------------------------------------------------------------------------
// Create a Router Instance and Run the Application
// -----------------------------------------------------------------------------
$router = new Router($_SERVER);
$router->run();

insertVisitorLog();