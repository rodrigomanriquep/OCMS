<?php
session_start();

// debugging method, just prints array contents to page. Delete if not needed.
var_dump($_SESSION);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">BrandName</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="patientRegister.php">Patient Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="staffRegister.php">Staff Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="staffDashboard.php">Staff Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="patientDashboard.php">Patient Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="doctorDashboard.php">Doctor Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logIn.php">Log In</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logOut.php">Log Out</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


    <?php

        if (isset($_SESSION['userType'])) {
            echo '<h3>Logged in as ' . $_SESSION['userType'] . '</h3>';
        }

    ?>

    <hr>

</body>
</html>
