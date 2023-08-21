<?php
require 'include/database.php';
include 'classes/Doctor.php';
include 'classes/Patient.php';
include 'classes/Visit.php';
include 'classes/Prescription.php';
include 'classes/LabExam.php';

include 'header.php';

// check if user is logged in and has a valid doctor ID
if (!isset($_SESSION['userID']) || $_SESSION['userType'] !== 'doctor') {
    header('Location: logIn.php');
    exit();
}

// get all patients registered and approved
$patient = new Patient($db);
$patients = $patient->selectAllApproved();



 // handle form submission for creating visit record, prescription, and lab exam
 if ($_SERVER['REQUEST_METHOD'] === 'POST'){
     $visit = new Visit($db);
     $doctorID = $_SESSION['userID'];
     $patientID = $_POST['patientID'];
     // $date = $_POST['date'];
     $details = $_POST['details'];
     if ($visit->createVisit($patientID, $doctorID, $details)) {
       echo 'Visit recorded';
   } else {
       echo 'Error creating visit';
   }


 }

    ?>

<!DOCTYPE html>
<html>
   <head>
     <meta charset="UTF-8">
     <title>New Visit Record</title>
       <script>
           function updateSelectedPatientID(selectElement) {
               var selectedPatientID = document.getElementById("selectedPatientID");
               selectedPatientID.value = selectElement.value;
           }
       </script>
   </head>
   <body>
     <h1>New Visit Record</h1>
<br>
<h3>Select patient for record</h3>

<form action="createVisit.php" method="post">
  <label for="patientID">Patient:</label>
  <select id="patientID" name="patientID" onchange="updateSelectedPatientID(this)" required>
     <?php foreach ($patients as $p) : ?>
         <option value="<?= $p['PatientID'] ?>">
             <?= $p['FirstName'] . ' ' . $p['LastName'] . ' ('.'ID:' . $p['PatientID'] . ')' ?>
         </option>
     <?php endforeach; ?>
  </select>
<br><br>

<!-- Hidden fields for storing patient and doctor IDs -->
<input type="hidden" id="doctorID" name="doctorID" value="<?= $_SESSION['userID'] ?>">
    <input type="hidden" id="selectedPatientID" name="patientID" value="<?= $patients[0]['PatientID'] ?>">


<!-- Visit inputs -->
<label for="date">Current Date:</label>
<input type="" id="" name="" readonly value="<?= date('Y-m-d') ?>" required>
<br><br>

<label for="details">Details:</label>
<textarea id="details" name="details" rows="4" cols="50"></textarea>
<br><br>

<input type="submit" value="Create Visit Record">
<!--    // button to return to dashboard-->
    <button type="button" onclick="window.location.href='doctorDashboard.php'">Return to Dashboard</button>

</form>
