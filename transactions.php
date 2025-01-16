<?php
require "config.php";
require "models/db.php";

DB::connect(); // Establish the database connection
session_start();

// Get the current user ID from the session
$userID = $_SESSION['userId'] ?? null;

// Check if user ID exists to avoid errors
if (!$userID) {
    die(json_encode(["error" => "User ID is not set in the session."]));
}

// Define the parameters for the query
$data = ['seller_id' => $userID];

// Fetch data from the database
try {
    $result = DB::select('cars_details', '*', 'seller_id = :seller_id', '', '', $data);
    $result1 = $result->fetchAll(PDO::FETCH_ASSOC);

    // Output the fetched results in JSON format
    header('Content-Type: application/json');
    echo json_encode($result1, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    // Handle potential errors and output them in JSON format
    header('Content-Type: application/json');
    echo json_encode(["error" => $e->getMessage()]);
}
