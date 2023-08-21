<?php
// Include the Staff class and create a new instance
require('include/database.php');
require('classes/Staff.php');
include 'header.php';

// Check if user is logged in and redirect to login page if not
 if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true || ($_SESSION['userType'] !== 'staff')) {
     header('Location: login.php');
     exit;
 }

$staff = new Staff($db);

// Get the user ID from the session variable
$staffID = $_SESSION['userID'];
$pendingApprovals = $staff->getPendingApprovals();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['approve'])) {
    $patientID = $_POST['patientID'];
    $staff->approvePatientAccount($patientID);
    header('Location: staffDashboard.php');
    exit;
}

// If approved, continue with the dashboard page
?>
<html>
<link rel="stylesheet" href="styles.css">
<head>
    <title>Staff Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['userType']; ?>!</h1>
    <p>Staff Dashboard:</p>
    <ul>
        <li><a href="userManagement.php">Account Management</a></li>
        <li><a href="viewRecordsStaff.php">View Records</a></li>
        <li><a href="generateReports.php">Generate Reports</a></li>
        <li><a href="inputLabResults.php">Input Lab Exam Results</a></li>
        <li><a href="updateStaff.php">Edit Profile</a></li>
        <li><a href="doctorRegister.php">Create Doctor Account</a></li>
        <li><a href="patientRegister.php">Create Patient Account</a></li>
        <li><a href="staffRegister.php">Create Staff Account</a></li>
        <li><a href="logOut.php">Logout</a></li>
    </ul>

    <h2>Pending Approvals</h2>
    <?php
    if (empty($pendingApprovals)) {
        echo 'No pending approvals.';
    } else {
    ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($pendingApprovals as $approval): ?>
            <tr>
                <form action="staffDashboard.php" method="post">
                <td><?php echo $approval['PatientID']; ?></td>
                <td><?php echo $approval['FirstName'] . ' ' . $approval['LastName']; ?></td>
                <td><?php echo $approval['Email']; ?></td>
                <td>
                    <input type="hidden" name="patientID" value="<?php echo $approval['PatientID']; ?>">
                    <input type="submit" name="approve" value="Approve">
                </td>
                </form>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php } ?>
</body>
</html>
