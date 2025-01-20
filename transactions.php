<?php
// File: index.php

require 'config.php';
require 'controllers/CarController.php';

session_start();

// Check if the user is logged in by verifying session data
if (!isset($_SESSION['userId'])) {
    die(json_encode(["error" => "User not logged in."]));
}

// Instantiate the controller and call the appropriate method
$carController = new CarController();
$carController->getCarDetails(); // Fetch and output car details

