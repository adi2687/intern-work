<?php
$username = $_POST['username'];
$password = $_POST['password'];
$data = [
    'username' => $username
];

require_once 'models/db.php';

DB::connect();
$result1 = DB::select('users', '*', 'name=:username', '', '', $data);
$result = $result1->fetch(PDO::FETCH_ASSOC);

if ($result && password_verify($password, $result['password'])) {
    // Password is correct
    session_start();
    session_regenerate_id(); // Regenerate session ID for security
    $_SESSION['userId'] = $result['userId'];
    header("Location: profile");
    exit();
} else {
    // Invalid credentials
    echo "Invalid username or password.";
    header("Location: ../intern-work");
}
?>