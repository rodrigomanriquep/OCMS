<?php
require 'include/database.php';
include 'classes/LabExam.php';
include 'header.php';

$labExam = new LabExam($db);
$exams = $labExam->selectByDoctor($_SESSION['userID']);
?> <?php
if ($exams) {
    // button to return to dashboard
    echo '<a href="doctorDashboard.php">Return to Dashboard</a>';
  echo '<h1>Lab Exam Results</h1>';
  echo '<h2>Pending Results</h2>';
  echo '<table>';
  echo '<thead><tr><th>Exam ID</th><th>Patient Name</th><th>Exam Item</th><th>Date</th><th>Result</th><th></th></tr></thead>';
  echo '<tbody>';
  // display all pending results
  foreach ($exams as $exam) {
    if ($exam['Result'] === 'Pending') {
      echo '<tr>';
      echo '<td>' . $exam['LabExamID'] . '</td>';
      echo '<td>' . $exam['firstName'] . ' ' . $exam['lastName'] . '</td>';
      echo '<td>' . $exam['ExamItem'] . '</td>';
      echo '<td>' . $exam['Date'] . '</td>';
      echo '<td>' . $exam['Result'] . '</td>';
      echo '<td><a href="updateRecords.php?LabExamID=' . $exam['LabExamID'] . '">Update</a></td>';
      echo '</tr>';
    }
  }
  echo '</tbody></table>';

  // display all completed results
  echo '<h2>Completed Lab Results</h2>';
  echo '<table>';
  echo '<thead><tr><th>Exam ID</th><th>Patient Name</th><th>Health Card</th></th><th>Exam Item</th><th>Date</th><th>Result</th><th>Normal Range</th><th></th></tr></thead>';
  echo '<tbody>';
  foreach ($exams as $exam) {
    if ($exam['Result'] !== 'Pending') {
      echo '<tr>';
      echo '<td>' . $exam['LabExamID'] . '</td>';
      echo '<td>' . $exam['firstName'] . ' ' . $exam['lastName'] . '</td>';
      echo '<td>' . $exam['healthCardNumber'] . '</td>';
      echo '<td>' . $exam['ExamItem'] . '</td>';
      echo '<td>' . $exam['Date'] . '</td>';
      echo '<td>' . $exam['Result'] . '</td>';
        if ($exam['NormalRange'] == 0) {
            echo '<td>Fail</td>';
        } else {
            echo '<td>Pass</td>';
        }
      echo '</tr>';
    }
  }
  echo '</tbody></table>';
} else {
  echo 'No lab exam results found.';
}


?>
