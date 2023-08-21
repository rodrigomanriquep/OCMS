<?php
// Start the session
session_start();

// Clear the session data
session_unset();
session_destroy();

// Redirect the user to the home page after 5 seconds
echo 'You have been logged out. Redirecting to home...';
header('Refresh: 5; URL= index.php');
exit;
?>
