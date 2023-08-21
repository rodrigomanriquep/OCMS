<?php
//This is the Registration Page, upon successful patient entry, redirect to the Password creation page and pass along the patient entry ID to be used in it. Register -> CreatePassword -> Landing Page

unset($_SESSION['patientID'], $_SESSION['role'], $_SESSION['email']);

include 'classes/Patient.php';
require 'include/database.php';
include 'header.php';

// check if user is logged in and has a valid patient ID
// if (isset($_SESSION['patientID']) || isset($_SESSION['staffID'])) {
//     header('Location: index.php');
//
//     exit();
// }

// If the form was submitted, create a new patient object and insert the new patient into the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient = new Patient($db);
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $homeAddress = $_POST['address'];
    $healthCardNumber = $_POST['healthCard'];
        $role = 'patient';

        // Insert the new patient into the database
    if ($patient->insert($firstName, $lastName, $email, $phone, $homeAddress, $healthCardNumber, $role)) {
        // Get the patientID from the insert_id property of the database object
        $_SESSION['patientID'] = $db->insert_id;
            $_SESSION['role'] = $role;
            $_SESSION['email'] = $email;
            // Redirect to the create password page
        header('Location: createPassword.php');
        exit();
    } else {
        echo 'Error registering new patient';
    }
}
?>

<!DOCTYPE html>
<link rel="stylesheet" href="styles.css">
<meta charset="utf-8">
<html lang="en" dir="ltr">
<html>
   <head>
     <meta charset="UTF-8">
     <title>New Patient Registration</title>
   </head>
   <body>
      <div class="registration">
     <h1>New Patient Registration</h1>
   </div>
     <form action="patientRegister.php" method="post">
       <div class="form-group">
       <label for="firstName">First Name:</label>
       <input type="text" id="firstName" name="firstName" required><br><br>

       <label for="lastName">Last Name:</label>
       <input type="text" id="lastName" name="lastName" required><br><br>

       <label for="email">Email:</label>
       <input type="email" id="email" name="email" required><br><br>

       <label for="phone">Phone:</label>
       <input type="text" id="phone" name="phone" required><br><br>

       <label for="address">Home Address:</label>
       <input type="text" id="address" name="address" required><br><br>

       <label for="healthCard">Health Card Number:</label>
       <input type="text" id="healthCard" name="healthCard" required><br><br>

       <label for="healthCard">Role:</label>
       <input type="text" id="role" name="role" required><br><br>
        </div>
        <button>Register Now</button>
        <button type="button" onclick="window.location.href='index.php'">Return to Home</button>
     </form>
     <footer>
     <p>&copy; 2023 OCMS. All rights reserved.</p>
   </footer>
   </body>
</html>