<?php
require 'include/database.php';
include 'classes/Prescription.php';
include 'header.php';

// check if doctor is logged in
 if ($_SESSION['role'] !== 'doctor') {
   echo ('You are not authorized to view this page. Redirecting to home...');
   //redirect to index.php after 5 seconds
    header('Refresh: 5; URL=index.php');



 }

 // Get the user ID from the session variable and use it to get the user's prescriptions
$prescription = new Prescription($db);
$prescriptions = $prescription->selectByDoctor($_SESSION['userID']);
// Display the prescriptions
// button to return to doctor dashboard
echo '<a href="doctorDashboard.php">Return to Dashboard</a>';

if ($prescriptions) {
  echo '<h1>Patient Prescriptions</h1>';

  echo '<table>';
  echo '<thead><tr><th>Prescription ID</th><th>Patient Name</th><th>Medicine</th><th>Quantity</th><th>Dose</th><th>Refillable</th><th>Date</th></tr></thead>';
  echo '<tbody>';
  foreach ($prescriptions as $prescription) {
      echo '<tr>';
      echo '<td>' . $prescription['PrescriptionID'] . '</td>';
      echo '<td>' . $prescription['firstName'] . ' ' . $prescription['lastName'] . '</td>';
      echo '<td>' . $prescription['Medicine'] . '</td>';
      echo '<td>' . $prescription['Quantity'] . '</td>';
      echo '<td>' . $prescription['Dose'] . '</td>';
      echo '<td>' . ($prescription['Refillable'] ? 'Yes' : 'No') . '</td>';

      echo '</tr>';
  }
  echo '</tbody></table>';
} else {
  echo 'No patient prescriptions found.';
}
?>
