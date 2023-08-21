<?php
// Include database and classes
require('include/database.php');
require('classes/Staff.php');
require('classes/Patient.php');
require('classes/Doctor.php');
include('header.php');

// Check if user is logged in and has a valid staff ID
 if (!isset($_SESSION['userID']) || $_SESSION['userType'] !== 'staff') {
     // If not, redirect to login page after 5 seconds
        echo 'You are not authorized to view this page. Redirecting to home...';
        header('Refresh: 5; URL=index.php');
     exit();
 }

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

}

// Get user type from URL parameter or form submission
$userType = isset($_GET['type']) ? $_GET['type'] : (isset($_POST['userType']) ? $_POST['userType'] : '');
?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Staff Dashboard</title>
    </head>
<body>

    <h1>Welcome, <?php echo $_SESSION['userType']; ?>!</h1>
<?php if ($userType === '') { ?>
    <form method="post">
        <label for="userType">User Type:</label>
        <select id="userType" name="userType" required>
            <option value="patient">Patient</option>
            <option value="doctor">Doctor</option>
            <option value="staff">Staff</option>
        </select>
        <input type="submit" value="Submit">
        <button type="button" onclick="window.location.href='staffDashboard.php'">Return to Dashboard</button>
    </form>
<?php } else { ?>
    <h2><?php echo ucfirst($userType) . 's List'; ?></h2>
    <br>


<button> <a href="userManagement.php">Back</a> </button>
    <?php
    switch ($userType) {
        case 'patient':
            // Get all approved patients
            $patient = new Patient($db);
            $patients = $patient->selectAll();
            if ($patients) {
                echo '<table>';
                echo '<thead><tr><th>Patient ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Health Card Number</th><th>Actions</th></tr></thead>';
                echo '<tbody>';
                foreach ($patients as $p) {
                    echo '<tr>';
                    echo '<td>' . $p['PatientID'] . '</td>';
                    echo '<td>' . $p['FirstName'] . '</td>';
                    echo '<td>' . $p['LastName'] . '</td>';
                    echo '<td>' . $p['Email'] . '</td>';
                    echo '<td>' . $p['Phone'] . '</td>';
                    echo '<td>' . $p['HealthCardNumber'] . '</td>';
                        echo '<td><a href="viewPatientAccount.php?id=' . $p['PatientID'] . '">Account Actions</a> </td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo 'No approved patients found.';
            }
       }  if ($userType == 'doctor') {

// Get all doctors from the database
        $doctor = new Doctor($db);
            $doctors = $doctor->selectAll();
            if ($doctors) {
                echo '<h1>Doctors List</h1>';
                echo '<table>';
                echo '<thead><tr><th>Doctor ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Specialization</th><th>Role</th><th>Actions</th></tr></thead>';
                echo '<tbody>';
                foreach ($doctors as $doc) {
                    echo '<tr>';
                    echo '<td>' . $doc['DoctorID'] . '</td>';
                    echo '<td>' . $doc['FirstName'] . '</td>';
                    echo '<td>' . $doc['LastName'] . '</td>';
                    echo '<td>' . $doc['Email'] . '</td>';
                    echo '<td>' . $doc['Phone'] . '</td>';
                    echo '<td>' . $doc['Specialization'] . '</td>';
                    echo '<td>' . $doc['Role'] . '</td>';
                    echo '<td><a href="viewDoctorAccount.php?id=' . $doc['DoctorID'] . '">Account Actions</a> </td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
            } else {
                echo 'No doctors found.';
            }
    } if ($userType == 'staff') {
// Get all staff from the database
    $staff = new Staff($db);
    $staffMembers = $staff->selectAll();
    if ($staffMembers) {
        echo '<h1>Staff List</h1>';
        echo '<table>';
        echo '<thead><tr><th>Staff ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        foreach ($staffMembers as $staffMember) {
            echo '<tr>';
            echo '<td>' . $staffMember['StaffID'] . '</td>';
            echo '<td>' . $staffMember['FirstName'] . '</td>';
            echo '<td>' . $staffMember['LastName'] . '</td>';
            echo '<td>' . $staffMember['Email'] . '</td>';
            echo '<td>' . $staffMember['Phone'] . '</td>';
            echo '<td>' . $staffMember['Role'] . '</td>';
            echo '<td><a href="viewStaffAccount.php?id=' . $staffMember['StaffID'] . '">Account Actions</a> </td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo 'No staff found.';
    }
}}
?>

