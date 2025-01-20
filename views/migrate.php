<?php

require_once "../models/migrator.php";
$tables = [
    'users' => 'auth/users.sql',
    'car_details' => 'auth/car_details.sql'
];

$migrate = Migrator::migrate($tables);

echo json_encode($migrate);