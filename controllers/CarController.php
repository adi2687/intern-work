<?php
// File: controllers/CarController.php

require_once 'models/db.php';
 
class CarController
{
    public function getCarDetails()
    {
        DB::connect(); 
        
        $userID = $_SESSION['userId'] ?? null;

        if (!$userID) {
            die(json_encode(["error" => "User ID is not set in the session."]));
        }

        $data = ['seller_id' => $userID];

        try {
            $result = DB::select('cars_details', '*', 'seller_id = :seller_id', '', '', $data);
            $result1 = $result->fetchAll(PDO::FETCH_ASSOC);

            header('Content-Type: application/json');
            echo json_encode($result1, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}
