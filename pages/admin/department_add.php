<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Departments - Add</title>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="js/customized_alert.js"></script>

</head>

<body>
  <?php
  include("../../includes/identity_nav.php");
  include("menu_nav.html");
  include("../../includes/alerts.php");
  ?>


  <section class="mx-auto grades text-center min-vh-100 py-5 px-3">

    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white"><?php echo isset($_POST['edit']) ? 'Edit Departent' : 'Add Department'; ?></h2>
    </header>

    <div class="container">
      <div class="row align-items-center justify-content-center">
        <form action="" method="post" class="form-group col-md-6 bg-dark text-white p-5 rounded">
          <div class="col mb-3">
            <label for="name" class="form-label">Department Name</label>
            <input type="text" class="form-control text-center" name="name" id="name" value="<?php echo isset($_POST['edit']) ? $_POST['dept_name'] : ''; ?>">
          </div>

          <!-- Submit Button -->
          <div class="text-center">
            <input type="submit" class="btn btn-primary" value="<?php echo isset($_POST['edit']) ? 'Edit Department' : 'Add Department'; ?>" name="new_dept">
          </div>
        </form>
      </div>
    </div>
  </section>

</body>


</html>

<?php

session_start(); // Start the session at the beginning of your script

if (isset($_POST["edit"])) {
  $_SESSION["dept_id_edit"] = $_POST["edit"];
}

if (isset($_POST["new_dept"])) {

  $dept_name = $_POST["name"];

  if (isset($_SESSION["dept_id_edit"])) {
    // Perform an update
    $update_query = "UPDATE department SET name = '$dept_name' WHERE id = '" . $_SESSION["dept_id_edit"] . "' ";
    $update = $conn->query($update_query);

    unset($_SESSION["dept_id_edit"]);

    header("location: department_view.php?edit=true");
  } else {
    // Perform an insert
    $insert_query = "INSERT into department (name) VALUES ('$dept_name')";
    $insert = $conn->query($insert_query);
  }


  if ($insert) {
    displayAlert("Department", "Added", "success", "Successful!", "Successfully.\nDatabase Insertion Done!", "OK");
  } else {
    displayAlert("Department", "Added", "error", "Failed!", "\nPlease Try Again", "Try Again");
  }
}





?>