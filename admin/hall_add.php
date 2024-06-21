<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halls - Add</title>
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
      <h2 class=" f-header fs-1 fw-bold text-white">Add Hall</h2>
    </header>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <form action="" method="post" class="bg-dark text-white p-4 rounded">
            <!-- Hall Number -->
            <div class="row mb-3">
              <center>
                <div class="col-md-5">
                  <label for="hall_num" class="form-label">Hall Number:</label>
                  <input type="number" class="form-control text-center" name="hall_num" id="hall_num" min="1" max="100" step="1">
                </div>
              </center>
            </div>
            <!-- Building and Location -->
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="building" class="form-label">Building:</label>
                <input type="text" class="form-control text-center" name="building" id="building">
              </div>
              <div class="col-md-6">
                <label for="location" class="form-label">Location:</label>
                <select name="location" id="location" class="form-select text-center">
                  <option value="" disabled selected>Select location</option>
                  <option value="Moharram Bek">Moharram Bek</option>
                  <option value="Shatby">Shatby</option>
                  <option value="Abu Qir">Abu Qir</option>
                </select>
              </div>
            </div>

            <!-- Level and Capacity -->
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="floor" class="form-label">Level:</label>
                <input type="number" class="form-control text-center" name="floor" id="floor" min="0" max="6">
              </div>
              <div class="col-md-6">
                <label for="capacity" class="form-label">Capacity:</label>
                <input type="number" class="form-control text-center" name="capacity" id="capacity">
              </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
              <input type="submit" class="btn btn-primary" value="Add Hall" name="new_hall">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  </form>
</body>

</html>
<?php
if (isset($_POST["new_hall"])) {
  $hall_num = $_POST["hall_num"];
  $location = $_POST["location"];
  $building = $_POST["building"];
  $floor = $_POST["floor"];
  $capacity = $_POST["capacity"];

  $insert_query = "INSERT INTO
    hall (
        id,
        location,
        building,
        floor,
        capacity
    )
    VALUES (
        '$hall_num',
        '$location',
        '$building',
        $floor,
        $capacity
    )
    ";

  $insert = $conn->query($insert_query);

  if ($insert) {
    displayAlert("Hall", "Added", "success", "Successful!", "Successfully.\nDatabase Insertion Done!", "OK");
  } else {
    displayAlert("Hall", "Added", "error", "Failed!", "\nPlease Try Again", "Try Again");
  }
}
?>