<?php
// This is the staff registration page. Input user info into fields, submits to Staff table

include 'classes/Staff.php';
require 'include/database.php';
include 'header.php';


// Check if user is logged in and redirect to login page if not
//if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true || ($_SESSION['userType'] !== 'staff')) {
//    header('Location: login.php');
//    exit;
//}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff = new Staff($db);
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = 'staff';

    if ($staff->insert($firstName, $lastName, $email, $phone, $role)) {
        
          // Get the staffID from the insert_id property of the database object
        $_SESSION['staffID'] = $db->insert_id;
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email;
        header('Location: createStaffPassword.php');
        exit();
    } else {
        echo 'Error registering new staff';
    }
}
?>

<!DOCTYPE html>
<link rel="stylesheet" href="styles.css">
<html>
   <head>
     <meta charset="UTF-8">
     <title>New Staff Registration</title>
   </head>
   <body>
     <h1>New Staff Registration</h1>

     <form action="staffRegister.php" method="post">
       <label for="firstName">First Name:</label>
       <input type="text" id="firstName" name="firstName" required><br><br>

       <label for="lastName">Last Name:</label>
       <input type="text" id="lastName" name="lastName" required><br><br>

       <label for="email">Email:</label>
       <input type="email" id="email" name="email" required><br><br>

       <label for="phone">Phone:</label>
       <input type="text" id="phone" name="phone" required><br><br>

       <label for="role">Role:</label>
       <input type="text" id="role" name="role" value="staff" disabled required><br><br>

       <input type="submit" value="Submit">
     </form>
   </body>
</html>
