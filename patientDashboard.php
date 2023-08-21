<?php
// Include the Patient class and create a new instance
require_once('include/database.php');
require_once 'classes/Patient.php';
include 'header.php';


// Check if user is logged in and redirect to login page if not
 if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true || ($_SESSION['userType'] !== 'patient')) {
     header('Location: login.php');
     exit;
 }

$patient = new Patient($db);

// Get the user ID from the session variable
$patientID = $_SESSION['userID'];

// Check if the user is approved
if (!$patient->isApproved($patientID)) {
    // If not approved, display a message and prevent access to the dashboard
    echo 'Your account is pending approval. Redirecting to home...';
    // Redirect to the login page after 5 seconds
    header('Refresh: 5; URL=login.php');
    exit;
}

// If approved, continue with the dashboard page

?>
<html>
<link rel="stylesheet" href="styles.css">
<head>
    <title>Patient Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['userType']; ?>!</h1>
    <p>Patient Dashboard:</p>
    <ul>
        <li><a href="viewDoctors.php">View Doctors</a></li>
        <li><a href="viewPatientRecords.php">View Patient Records</a></li>
        <li><a href="updatePatient.php">Edit Profile</a></li>
        <li><a href="logOut.php">Logout</a></li>
    </ul>
</body>
</html>
