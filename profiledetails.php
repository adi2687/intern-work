<?php
session_start(); // Start the session to access session variables

$userId = $_SESSION['userId'] ?? null;

require_once("config.php");
require_once("models/db.php");

if (!$userId) {
    echo "User not logged in!";
    exit; // Stop execution if the user is not logged in
}

try {
    DB::connect();
} catch (Exception $e) {
    echo "Error connecting to the database: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carName = htmlspecialchars($_POST['carname'] ?? '');
    $carPrice = htmlspecialchars($_POST['carprice'] ?? '');
    $carColor = htmlspecialchars($_POST['carcolor'] ?? '');
    $carYear = htmlspecialchars($_POST['caryear'] ?? '');
    $carModel = htmlspecialchars($_POST['carmodel'] ?? '');

    // Handle image upload
    $carImage = '';
    if (isset($_FILES['carimage']) && $_FILES['carimage']['error'] === UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['carimage']['tmp_name'];
        $imageName = basename($_FILES['carimage']['name']);
        $imageExt = pathinfo($imageName, PATHINFO_EXTENSION);
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

        // Validate file extension
        if (in_array(strtolower($imageExt), $allowedExt)) {
            $newImageName = uniqid('car_') . '.' . $imageExt;
            $targetDir = 'uploads/';
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $targetFile = $targetDir . $newImageName;

            // Move the file to the target directory
            if (move_uploaded_file($imageTmpName, $targetFile)) {
                $carImage = $newImageName;
            } else {
                echo "<p style='color: red;'>Error uploading image.</p>";
            }
        } else {
            echo "<p style='color: red;'>Invalid image format. Allowed formats: jpg, jpeg, png, gif.</p>";
        }
    }

    // Ensure all fields are filled
    if (!empty($carName) && !empty($carPrice) && !empty($carColor) && !empty($carYear) && !empty($carModel)) {
        $data = [
            'car_name'  => $carName,
            'car_price' => $carPrice,
            'car_color' => $carColor,
            'car_model' => $carModel,
            'seller_id' => $userId, 
            'car_image' => $carImage, // Store the image filename
        ];

        // Insert into database
        DB::insert('cars_details', $data);

        echo "<p style='color: green;'>Car listing added successfully!</p>";
        header("Location: profile");
    } else {
        echo "<p style='color: red;'>Please fill in all fields.</p>";
    }
}

// $result = DB::select('users', '*', 'userID = :userID', '', '', [':userID' => $userId]);

// if (!empty($result)) {
//     foreach ($result as $user) {
//         echo "<section>
//             <h2>Personal Information</h2>
//             <p><span class='highlight'>Name:</span> " . htmlspecialchars($user['name']) . "</p>
//             <p><span class='highlight'>Phone:</span> " . htmlspecialchars($user['phone']) . "</p>
//             <p><span class='highlight'>Email:</span> " . htmlspecialchars($user['email']) . "</p>
//         </section>";
//     }
// } else {
//     echo "<p>No user found with the given ID.</p>";
// }
?>
