<?php

require_once 'models/db.php';

class ViewBookingController
{
    public function getBooking()
    {
        $userID = $_SESSION['userId'] ?? null;
        // echo $userID;
        if (!$userID) {
            die(json_encode(["error" => "User ID is not set in the session."]));
        }

        try {
            $data = ['user_id' => $userID];
            $result2 = DB::select('cars_details', "*", 'seller_id=:user_id', '', '', $data);
            $resultfinal = $result2->fetchAll(PDO::FETCH_ASSOC);

            $allBookings = [];

            foreach ($resultfinal as $row) {
                $car_id = $row['id'];
                // echo $car_id;
                $data = ['car_id' => $car_id];
                $result = DB::select('bookings', '*', 'car_id = :car_id', '', '', $data);
                $result1 = $result->fetchAll(PDO::FETCH_ASSOC);

                $allBookings[] = $result1;
            }

            return $allBookings;

        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}
