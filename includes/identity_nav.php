<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/css/bootstrap.min.css">
  <link rel="stylesheet" href="/css/index.css">
  <link rel="stylesheet" href="/css/all.min.css">
  <link rel="shortcut icon" href="/images/university.png" type="image/x-icon">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="/js/bootstrap.bundle.min.js"></script>

  <script src="/js/confirmation_alert.js"></script>
  <script src="/js/customized_alert.js"></script>

  <?php
  session_start();
  include("db_connection.php");
  ?>

  <?php
  if ($_SESSION["role"] == "admin" && $_SESSION["gender"] == "Male") {
    $title = "Mr. ";
  } elseif ($_SESSION["role"] == "admin" && $_SESSION["gender"] == "Female") {
    $title = "Mrs. ";
  } elseif ($_SESSION["role"] == "Professor") {
    $title = "Dr. ";
  }
  ?>

</head>

<body>

  <div class="bg-dark w-100 d-flex pt-3 px-2 justify-content-between align-items-center">

    <div></div>

    <div class="text-white fs-6">
      <ul class="nav pe-4" style="list-style-type: none;">

        <li style="margin-right: 150px; cursor: pointer;" class="nav-item dropdown">
          <i class="fa-solid fa-circle-user"></i>
          <span style="margin-left: 10px;">Hi, <?php echo $title .  $_SESSION["fname"] ?></span>
          <ul class="dropdown-menu text-white" style="background-color: black; text-align: center;">
            <li class="text-info">
              <?php echo $_SESSION["email"] ?>
            </li>
            <li>
              <a class="text-white text-decoration-none" href="account.php">Account</a>
            </li>
            <li>
              <a class="text-white text-decoration-none" href="../login/logout.php?logout=true">Logout</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>

</body>

</html>