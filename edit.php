<?php
// Handle form submission
$request_uri = $_SERVER['REQUEST_URI'];
$segments = explode('/', $request_uri);
$id = end($segments);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $car_price = $_POST['car_price'];
    $car_availability = $_POST['car_availability'];

    // Validate input (extended validation)
    if (!empty($car_price) && !empty($car_availability) && is_numeric($car_price)) {
        require_once("models/db.php");
        DB::connect();

        // Prepare the update query
        // Prepare the data to be bound
        // Prepare the data to be bound for the SET clause
        $data = [
            'car_price' => $car_price,
            'car_availability' => $car_availability
        ];

        // Add the id parameter for the WHERE clause
        $params = $data;
        $result = DB::update('cars_details', $params, 'id='.$id.''
    );

        // Check if the update was successful
        if ($result) {
            echo "<p>Vehicle details updated successfully.</p>";
        } else {
            echo "<p>Error updating vehicle details.</p>";
        }


    } else {
        echo "<p>Please fill in all fields correctly.</p>";
    }
}

// Fetch the vehicle details based on the ID
require_once("models/db.php");
DB::connect();
$data = ['id' => $id];
$result = DB::select('cars_details', '*', 'id=:id', '', '', $data);
$result1 = $result->fetch(PDO::FETCH_ASSOC);

// Create the form with pre-filled values
echo "<form method='POST' action=''>";
echo "<h2>Vehicle Details</h2>";

// Car Name (non-editable)
echo "<label for='car_name'>Car Name:</label>";
echo "<input type='text' name='car_name' id='car_name' value='" . htmlspecialchars($result1['car_name']) . "' readonly><br>";

// Car Model (non-editable)
echo "<label for='car_model'>Car Model:</label>";
echo "<input type='text' name='car_model' id='car_model' value='" . htmlspecialchars($result1['car_model']) . "' readonly><br>";

// Car Price (editable)
echo "<label for='car_price'>Car Price:</label>";
echo "<input type='text' name='car_price' id='car_price' value='" . htmlspecialchars($result1['car_price']) . "'><br>";

// Availability dropdown (editable)
echo "<label for='car_availability'>Availability:</label>";
echo "<select name='car_availability' id='car_availability'>";
echo "<option value='available'" . ($result1['car_availability'] == 'available' ? ' selected' : '') . ">Available</option>";
echo "<option value='sold'" . ($result1['car_availability'] == 'sold' ? ' selected' : '') . ">Sold</option>";
echo "</select><br>";

// Display image
echo "<label>Car Image:</label><br>";
echo "<img src='uploads/" . htmlspecialchars($result1['car_image']) . "' alt='Car Image' style='max-width: 200px;'><br>";

// Hidden field to pass the vehicle ID for update (already handled by URL, optional)
echo "<input type='hidden' name='car_id' value='" . $result1['id'] . "'>";

// Submit button
echo "<input type='submit' value='Update Vehicle'>";
echo "</form>";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        img {
            max-width: 200px;
            max-height: 200px;
            display: block;
            margin: 20px 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group p {
            color: #f00;
            font-size: 14px;
        }
    </style>
</head>

<body>
    

</body>
</html>