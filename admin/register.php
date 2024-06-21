<?php

include("../includes/db_connection.php");
include("../signup.html");

if (isset($_POST["new_admin"])) {
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $gender = $_POST["gender"];
  $birth = $_POST["bdate"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  $insert_query = "INSERT into
    Admin (
        first_name,
        last_name,
        gender,
        birth_date,
        email, 
        password
    )
    VALUES (
        '$fname',
        '$lname',
        '$gender',
        '$birth',
        '$email', 
        '$password'
    )
    ";


  $insert = $conn->query($insert_query);

  if ($insert) {
    echo "<script>";
    echo "alert ('Account Registred Successfully')";
    echo "</script>";
    header("location: login.html");
  } else {
    echo "<div style='background-color: #FFD2D2; color: #D8000C; padding: 10px; margin: 10px 0;'>Database insertion failed.</div>";
  }

  $adminId = mysqli_insert_id($conn);



  for ($i = 0; isset($_POST["phone" . $i]); $i++) {
    $phoneNumber = $_POST["phone" . $i];

    $insert_query = "INSERT INTO 
        admin_phone (
            admin_id,
            phone_number
        )
        VALUES (
            '$adminId',
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
