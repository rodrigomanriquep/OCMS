<?php
include 'classes/Patient.php';
require 'include/database.php';
include 'header.php';

 ?>

<!DOCTYPE html>
<link rel="stylesheet" href="styles.css">
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>OCMS</title>

  </head>
  <body>
 <!-- ***** Main Banner Area Start ***** -->

 <div class="banner">
    <h1>Welcome to OCMS</h1>
    <h2>Get access to quality healthcare from the comfort of your home.</h2>

    <a href="patientRegister.php">
      <button>Register Now</button>
    </a>

  </div>

  <!-- ***** Main Section2 Area Starts ***** -->
  <div class="section2">
    <h1>Who we are</h1>
    <img src="assets/images/logo.jpg">
    <p>Online Clinic Management System is a web application designed to help small clinics manage their patients and appointments more efficiently. Our system provides a user-friendly platform for doctors, staff,
      and patients to access important information such as lab test results, prescriptions, and patient visit details. Our system also allows patients to create and manage their own accounts, and doctors to track their
      patients' progress and prescribe appropriate treatments. With our system, clinics can streamline their operations, reduce wait times, and provide better care for their patients. Trust Online Clinic Management System to manage your clinic's data effectively and efficiently.</p>

    </div>

    <!-- ***** Main Section3 Area Starts ***** -->
    <div class="section3">
      <h1>What we do</h1>
      <img src="assets/images/logo3.png">
      <p>Online Clinic Management System is a comprehensive web application designed to streamline the management of clinics and their patients. With our system, doctors can easily manage appointments, track patient progress, and prescribe appropriate treatments. Patients can create and manage their own accounts, access lab test results, and view their visit details. Our system also provides staff with the tools they need to manage patient records, approve new patient accounts, and generate reports on clinical operations. We understand that the healthcare industry can be complex and time-consuming, which is why our system is designed to simplify clinical management, reduce wait times, and enhance the overall patient experience. Let us help you manage your clinic's data and operations effectively and efficiently.</p>

      </div>

      <div>

      </div>

    <!-- ***** Footer Area Start ***** -->
    <footer>
    <p>&copy; 2023 OCMS. All rights reserved.</p>
  </footer>

  </body>
</html>
<h1>Landing Page, generic clinic content and pics</h1>
<br>
<h4>Access control is on. Need to be logged in as correct role and can only do and view things associated with that role. <br> Register patient accounts, register staff account to approve them and log in as patient role. Log in as staff to register doctor accounts, then log in as that doctor</h4>
