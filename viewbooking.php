<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "controllers/ViewBookingController.php";

// Create an instance of ViewBookingController
$viewcars = new ViewBookingController();

// Get the booking data (assuming it returns an array of bookings directly)
$bookings = $viewcars->getBooking();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, rgb(195, 73, 42), #feb47b);
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #333;
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 24px;
        }

        h1 {
            margin: 20px 0;
            text-align: center;
            color: #4CAF50;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        .table-wrapper {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .no-data {
            text-align: center;
            font-size: 18px;
            color: #888;
            font-style: italic;
        }

        .booking-card {
            background-color: #fff;
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .booking-card p {
            margin: 0;
        }

        .card-header {
            font-size: 20px;
            font-weight: bold;
        }
        img{
            width:140px;
            height:100px;
            border:1px solid gray
        }
    </style>
</head>

<body>

    <header>
        Car Booking System
    </header>

    <div class="container">
        <h2><a href="profile">Home</a></h2>
        <h1>Booking Details</h1>

        <?php if (empty($bookings) || !isset($bookings[0]) || empty($bookings[0])): ?>
            <p class="no-data">No booking details available.</p>
        <?php else: ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Car ID</th>
                            <th>Booking Date</th>
                            <th>Duration (hours)</th>
                            <th>Car image</th>
                            <th>Booker details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $bookingGroup): ?>
                            <?php foreach ($bookingGroup as $booking): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($booking['id']); ?></td>
                                    <td><?php echo htmlspecialchars($booking['car_id']); ?></td>
                                    <td><?php echo htmlspecialchars(substr($booking['timeofbooking'], 0, 11)); ?></td>
                                    <td><?php echo htmlspecialchars($booking['duration']); ?></td>
                                    <td>
                                        <?php
                                        $car_id = $booking['car_id'];
                                        $data = ['car_id' => $car_id]; // Pass the car_id for the query
                            
                                        // Perform the query to get car details based on car_id
                                        $car_image = DB::select('cars_details', '*', 'id = :car_id', '', '', $data);

                                        // Fetch the result if available
                                        $result1 = $car_image->fetch(PDO::FETCH_ASSOC);

                                        // Check if the car image exists
                                        if ($result1 && isset($result1['car_image'])) {
                                            $img = 'uploads/' . $result1['car_image'];
                                        } else {
                                            $img = 'uploads/default_car_image.jpg'; // Fallback image if no car image is found
                                        }
                                        ?>
                                        <img src="<?php echo htmlspecialchars($img); ?>" alt="Car Image" />
                                    </td>

                                    <?php
                                    $data = ['userId' => $booking['booker_id']];
                                    $userId = $booking['booker_id'];
                                    $result = DB::select('users', '*', 'userId=:userId', '', '', $data);
                                    $result1 = $result->fetch(PDO::FETCH_ASSOC);
                                    // var_dump($result1);
                                    $info = [
                                        "Email: " . htmlspecialchars($result1['email']) . "<br>",
                                        "Phone: " . htmlspecialchars($result1['phone']) . "<br>",
                                        "Name: " . htmlspecialchars($result1['name']) . "<br>"
                                    ];
                                    // Note: Avoid displaying passwords in plain text.
                                    $infoString = implode('', $info);
                                    ?>

                                    <td><?php echo $infoString ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </div>

</body>

</html>