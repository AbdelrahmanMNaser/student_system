<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student - Add</title>
</head>

<body>
  <?php
  include("../includes/identity_nav.php");
  include("menu_nav.html");
  include("../includes/alerts.php");
  ?>

  <script src="../js/customized_alert.js"></script>

  <section class="mx-auto grades text-center min-vh-100 py-5 px-3">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">Add Student</h2>
    </header>
    <div class="container">
      <div class="row justify-content-center">
        <form action="" method="post" class="bg-dark text-white col-md-6 p-4 rounded">
          <div class="mb-3">
            <label for="dept" class="form-label">
              <h5>Department Name:</h5>
            </label>
            <select name="dept" id="dept" class="form-select text-center">
              <option value="" disabled selected>Select department</option>
              <?php
              $retrieve_query = "SELECT name FROM department";
              $result = $conn->query($retrieve_query);
              while ($row = $result->fetch_assoc()) {
                echo "<option value = '" . $row['name'] . "'>" . $row["name"] . "</option>";
              }
              ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="id" class="form-label">ID:</label>
            <input type="text" class="form-control text-center" name="id" id="id" required>
          </div>


          <!-- First Name and Last Name -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="fname" class="form-label">First Name:</label>
              <input type="text" class="form-control text-center" name="fname" id="fname" required>
            </div>
            <div class="col-md-6">
              <label for="lname" class="form-label">Last Name:</label>
              <input type="text" class="form-control text-center" name="lname" id="lname" required>
            </div>
          </div>

          <!-- Gender and Birth Date -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="gender" class="form-label">Gender:</label>
              <select name="gender" id="gender" class="form-select text-center" required>
                <option value="">--Select--</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="birth" class="form-label">Birth Date:</label>
              <input type="date" class="form-control text-center" name="birth" id="birth" required>
            </div>
          </div>

          <!-- City and Street -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="city" class="form-label">City:</label>
              <input type="text" class="form-control text-center" name="city" id="city" required>
            </div>
            <div class="col-md-6">
              <label for="street" class="form-label">Street:</label>
              <input type="text" class="form-control text-center" name="street" id="street">
            </div>
          </div>

          <script src="../js/phone_input.js"></script>

          <!-- Phone Numbers -->
          <div id="inputArea" class="row g-2 mb-3">
            <!-- Phone number inputs will be added here -->
          </div>
          <p style="color: blue; cursor: pointer;" onclick="addPhoneNumberInput()">Add Phone Numbers</p>

          <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" id="email" class="form-control text-center">
          </div>


          <!-- Submit Button -->
          <div class="text-center">
            <input type="submit" class="btn btn-primary" value="Add Student" name="new_student">
          </div>
        </form>
      </div>
    </div>
  </section>


</body>

</html>


<?php

if (isset($_POST["new_student"])) {
  $id = $_POST["id"];
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $email = $_POST["email"];
  $gender = $_POST["gender"];
  $city = $_POST["city"];
  $street = $_POST["street"];
  $birth = $_POST["birth"];
  $dept_name = $_POST["dept"];
  $registration_date = date("y-m-d");

  $retrieve = "SELECT id FROM department WHERE name = '$dept_name'";

  $result = $conn->query($retrieve);

  if ($result && $result->num_rows > 0) {
    $dept_id = $result->fetch_assoc()['id'];
  }

  $insert_query = "
    INSERT into Student (
        id, 
        first_name, 
        last_name, 
        department_id, 
        registration_date,
        gender, 
        birth_date, 
        city, 
        street, 
        email
        ) 
    VALUES (
        '$id', 
        '$fname',  
        '$lname',  
        '$dept_id',
        '$registration_date',  
        '$gender', 
        '$birth', 
        '$city' , 
        '$street',  
        '$email'
        )
    ";

  $insert = $conn->query($insert_query);

  if ($insert) {
    displayAlert("Student", "Added", "success", "Successful!", "Successfully.\nDatabase Insertion Done!", "OK");
  } else {
    displayAlert("Student", "Added", "error", "Failed!", "\nPlease Try Again", "Try Again");
  }

  for ($i = 0; isset($_POST["phone" . $i]); $i++) {
    $phoneNumber = $_POST["phone" . $i];

    $insert_query = "INSERT INTO 
        student_phone (
            student_id,
            phone_number
        )
        vALUES (
            '$id',
            '$phoneNumber'
        )
        ";

    $insert = $conn->query($insert_query);
  }
}


?>