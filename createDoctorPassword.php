<?php
require_once 'include/database.php';
require_once 'classes/Authentication.php';
include 'header.php';

 if (!isset($_SESSION['doctorID'])) {
     header('Location: doctorRegister.php');
     exit();
 }

// Get the user ID from the session variable
$doctorID = $_SESSION['doctorID'];
$userType = $_SESSION['role'];
$email = $_SESSION['email'];

// if submitted, create the password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctorID = $_SESSION['doctorID'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    // Create a new login for the patient
    $auth = new Authentication($db);
    if ($auth->createLogin($doctorID, $userType, $email, $password)) {

        echo "Password created successfully! Redirecting to dashboard...";
        // log out the doctorID to force relogin
        unset($_SESSION['doctorID'], $_SESSION['role'], $_SESSION['email']);
        // redirect to dashboard after 5 seconds
        header("refresh:5;url=staffDashboard.php");

    } else {
        echo "Error creating password";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Doctor Password</title>
</head>
<body>
    <h3>Account entered into system</h3>
    <h1>Create Password</h1>
    <form action="createDoctorPassword.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" disabled required value="<?= $email ?>"><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Create Password">
    </form>
</body>
</html>
