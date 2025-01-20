<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "controllers/BookcarController.php";

// Instantiate the controller
$cardetails = new BookcarController();
$carData = $cardetails->Displaycars(); // Assuming this returns an array with car details

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $car_id = isset($_POST['id']) ? (int)$_POST['id'] : 0;  // Ensure car_id is an integer
    $duration = isset($_POST['duration']) ? (int)$_POST['duration'] : 0;  // Ensure duration is an integer
    
    if ($car_id > 0 && $duration > 0) {
        // Connect to the database and insert booking details
        DB::connect();
        $userId=$_SESSION['userId'];
        $data = [
            "car_id" => $car_id,
            "duration" => $duration,
            "booker_id"=>$userId
        ];
        
        // Insert data into the bookings table
        if (DB::insert('bookings', $data)) {
            $message = "Car booked successfully!";
        } else {
            $message = "Failed to book the car. Please try again.";
        }
        DB::close();
    } else {
        $message = "Invalid input. Please select a valid car and duration.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .car-item {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 300px;
        }
        .car-item img {
            width: 100%;
            height: auto;
            max-width: 200px;
            margin-bottom: 15px;
        }
        .car-item h2 {
            margin-bottom: 10px;
        }
        .car-item p {
            margin: 5px 0;
        }
        .message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<a href="../profile">Profile</a>
    <h1>Book cars</h1>

    <?php if (isset($message)): ?>
        <div class="<?php echo isset($success) ? 'message' : 'error-message'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php foreach ($carData as $car): ?>
    <div class="car-item">
        <form action="" method="POST" enctype="multipart/form-data">
            <h2><?php echo htmlspecialchars($car['car_name']) . " (" . htmlspecialchars($car['car_model']) . ")"; ?></h2>
            <img src="../uploads/<?php echo htmlspecialchars($car['car_image']); ?>" alt="Car Image">
            <p><strong>Price:</strong> $<?php echo htmlspecialchars($car['car_price']); ?></p>
            <p><strong>Color:</strong> <?php echo htmlspecialchars($car['car_color']); ?></p>
            <p><strong>Seller ID:</strong> <?php echo htmlspecialchars($car['seller_id']); ?></p>
            <p><strong>Created At:</strong> <?php echo htmlspecialchars($car['createdAt']); ?></p>
            <p><strong>Availability:</strong> <?php echo $car['car_availability'] ? htmlspecialchars($car['car_availability']) : 'N/A'; ?></p>
            
            <!-- Hidden field to pass the car ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($car['id']); ?>">

            <label for="number_of_days">Number of days to rent this car:</label>
            <input type="number" id="number_of_days" name="duration" placeholder="Enter number of days" required min="1">

            <button type="submit">Book</button>
        </form>
    </div>
    <?php endforeach; ?>

</body>
</html>
