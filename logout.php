<?php
session_unset();
session_destroy();

// Redirect to the homepage
header("Location: ../intern-work");
exit();
?>
