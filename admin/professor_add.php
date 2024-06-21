<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Professor - Add</title>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
      <h2 class=" f-header fs-1 fw-bold text-white">Add Professor</h2>
    </header>
    <div class="container">
      <div class="row align-items-center justify-content-center">

        <form action="" method="post" class="form-group col-md-6 bg-dark text-white p-5 rounded">
          <div class="mb-3">
            <label for="dept" class="form-label">Department:</label>
            <select name="dept" id="dept" class="form-select text-center">
              <option value="" disabled selected>Select department</option>
              <?php
              $retrieve_query = "SELECT name FROM department";
              $result = $conn->query($retrieve_query);
              while ($row = $result->fetch_assoc()) {
                echo "<option value = ' " . $row['name'] . "'>" . $row["name"] . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label for="fname" class="form-label">First Name:</label>
              <input type="text" class="form-control text-center" name="fname" id="fname">
            </div>

            <div class="col-md-6">
              <label for="lname" class="form-label">Last Name:</label>
              <input type="text" class="form-control text-center" name="lname" id="lname">
            </div>
          </div>

          <!-- Gender and Birth Date -->
          <div class="row g-2 mb-3">
            <div class="col-md-6">
              <label for="gender" class="form-label">Gender:</label>
              <select name="gender" id="gender" class="form-select text-center">
                <option value="" disabled selected>select gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="bdate" class="form-label">Birth Date:</label>
              <input type="date" class="form-control text-center" name="bdate" id="bdate">
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
          <script>
            removeButton.style.marginLeft = "8px";
          </script>

          <!-- Add phone number input area -->
          <div id="inputArea" class="row g-2 mb-3">
            <!-- Phone number inputs will be added here -->
          </div>
          <p style="color: blue; cursor: pointer;" onclick="addPhoneNumberInput()">Add Phone Numbers</p>

          <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" name="email" id="email" class="form-control text-center">
          </div>


          <div class="text-center">
            <input class="btn btn-primary mt-4" type="submit" value="Add Professor" name="new_professor">
          </div>
        </form>
      </div>
    </div>
  </section>

</body>

</html>

<?php

if (isset($_POST["new_professor"])) {
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $dept_name = $_POST["dept"];
  $gender = $_POST["gender"];
  $birth = $_POST["bdate"];
  $city = $_POST["city"];
  $street = $_POST["street"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  $retrieve = " SELECT id FROM department WHERE name = '$dept_name'";
  $result = $conn->query($retrieve);

  if ($result && $result->num_rows > 0) {
    $dept_id = $result->fetch_assoc()['id'];
  }

  $insert_query = "INSERT INTO
    professor (
        department_id,
        first_name,
        last_name,
        birth_date,
        gender,
        city,
        street
        email
    )
    VALUES (
        '$dept_id',
        '$fname',
        '$lname',
        '$birth',
        '$gender',
        '$city',
        '$street',
        '$email'
    )
    ";

  $insert = $conn->query($insert_query);

  if ($insert) {
    displayAlert("Professor", "Added", "success", "Successful!", "Successfully.\nDatabase Insertion Done!", "OK");
  } else {
    displayAlert("Professor", "Added", "error", "Failed!", "\nPlease Try Again", "Try Again");
  }

  $professorId = mysqli_insert_id($conn);


  for ($i = 0; isset($_POST["phone" . $i]); $i++) {
    $phoneNumber = $_POST["phone" . $i];

    $insert_query = "INSERT INTO 
        professor_phonenumbers (
            professor_id,
            phone_number
        )
        vALUES (
            '$professorId',
            '$phoneNumber'
        )
        ";

    $insert = $conn->query($insert_query);

    if ($insert) {
      echo "<div style='background-color: #DFF2BF; color: #4F8A10; padding: 10px; margin: 10px 0;'>" . "Phone " . $i . "Added Successfully" . "</div>";
    } else {

      echo "<div style='background-color: #FFD2D2; color: #D8000C; padding: 10px; margin: 10px 0;'>database insertion failed.</div>";
    }
  }
}
?>