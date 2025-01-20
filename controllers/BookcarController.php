<?php
require_once "models/db.php";
class BookcarController
{
    public function Displaycars()
    {
        DB::connect();
        $userId = $_SESSION['userId'];
        $data = ['seller_id' => $userId];

        $result = DB::select('cars_details', '*', 'seller_id!=:seller_id', '', '', $data);
        $result1 = $result->fetchAll(PDO::FETCH_ASSOC);
        return $result1;
    }


}