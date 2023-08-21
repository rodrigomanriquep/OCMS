<?php
require 'include/database.php';
include 'classes/Doctor.php';
include 'classes/Patient.php';
include 'classes/Visit.php';
include 'classes/Prescription.php';
include 'classes/LabExam.php';
include 'header.php';

// check if user is logged in as doctor
if (!isset($_SESSION['userID']) || $_SESSION['userType'] !== 'doctor') {
    header('Location: logIn.php');
    exit();
}

//if submit button is clicked, insert the lab exam into the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $labExam = new LabExam($db);

  // Get selected VisitID from the form
  $visitID = $_POST['visitID'];

  // Get patient, doctor, and visit information based on the selected VisitID
  $visit = new Visit($db);
  $visitInfo = $visit->selectOne($visitID);
  $patientID = $visitInfo['PatientID'];
  $doctorID = $visitInfo['DoctorID'];
  $examDate = $_POST['examDate'];

  $examItem = $_POST['examItem'];
  $result = 'Pending';
  $normalRange = 'Pending';

  if($labExam->insert($patientID, $doctorID, $visitID, $examDate, $examItem, $result, $normalRange)){
      echo 'Lab Exam recorded';
      echo $examDate;
  } else {
      echo 'Error creating Lab Exam';
  }
}
?>

<h3>Lab Exam Form</h3>
<h3>Select visit record for patient:</h3>
 <h4>(Select from all patients who have a visit record with logged in doctor)</h4>
<form action="createLabExam.php" method="post">
  <label for="visitID">Visit Record:</label>
  <select id="visitID" name="visitID" required>
    <?php
      // get all visits for this doctor
      $visit = new Visit($db);
      $visits = $visit->getVisitsByDoctor($_SESSION['userID']);
      foreach ($visits as $v) :
        $patient = new Patient($db);
        $patientInfo = $patient->selectOne($v['PatientID']);
    ?>
    <option value="<?= $v['VisitID'] ?>">
      <?= $patientInfo['FirstName'] . ' ' . $patientInfo['LastName'] . ' (' . 'ID:' . $v['PatientID'] . ')' . ' - ' . $v['Date'] ?>
    </option>
    <?php endforeach; ?>
  </select>
  <br><br>

  <!-- Inputs -->
  <label for="examDate">Exam Date:</label>
  <input type="date" id="examDate" name="examDate" required>
  <br><br>

  <label for="examItem">Exam Item:</label>
  <input type="text" id="examItem" name="examItem" required>
  <br><br>

  <input type="submit" name="submit" value="Create Exam Record" />
    <button type="button" onclick="window.location.href='doctorDashboard.php'">Return to Dashboard</button>
</form>
