<?php

require_once 'include/database.php';
require_once 'classes/Authentication.php';
include 'header.php';

// check if user is logged in and has a valid patient ID or staff ID
// if (!isset($_SESSION['patientID'])) {
//     header('Location: patientRegister.php');
//     exit();
// }


$patientID = $_SESSION['patientID'];
  $userType = $_SESSION['role'];
      $email = $_SESSION['email'];

      // on submit, create a new login for the patient
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientID = $_SESSION['patientID'];

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Create a new login for the patient
    $auth = new Authentication($db);
    if ($auth->createLogin($patientID, $userType, $email, $password)) {
      unset($_SESSION['patientID'], $_SESSION['role'], $_SESSION['email']);

        echo "Password created successfully";
        ?> <h4>Password Set! Await staff confirmation to log in</h4> <?php
        // button to go to index
        echo "<a href='index.php'>Return to Home</a>";
    } else {
        echo "Error creating password";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Password</title>
</head>
<body>
<!--    // Create password for patient-->
    <h3>Account entered into system, now set your password</h3>
    <h1>Create Password</h1>
    <form action="createPassword.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" disabled required value="<?= $email ?>"><br><br>

        <label for="userType">User Type:</label>
        <select id="userType" disabled name="userType">
            <option value="<?= $userType ?>"><?= $userType ?></option>
        </select><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Create Password">
    </form>
</body>
</html>
