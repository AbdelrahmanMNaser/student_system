<?php

include ("../includes/db_connection.php");

session_start();

if (isset($_POST["login_email"])) {
    // Handle the email submission
    $role = $_POST["role"];
    $email = $_POST["email"];

    // Store role and email in session to use after password submission
    $_SESSION["role"] = $role;
    $_SESSION["email"] = $email;


    // Check if the email exists
    $query = "SELECT * FROM $role WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($user["password"] == null) {
            include ("login_no-password.html");
        } else {
            include ("login_password.html");
        }

    } else {       
         // The email does not exist

        header("location: login.html?error=notexist");
    }

} elseif (isset($_POST["login_pass"])) {
    // Handle the password submission
    $role = $_SESSION["role"];
    $email = $_SESSION["email"];
    $password = $_POST["password"];


    // Check if the email and password match
    $query = "SELECT * FROM $_SESSION[role] WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        // The email and password are correct, set session variables and redirect
        $user = $result->fetch_assoc();

        $_SESSION["id"] = $user["id"];
        $_SESSION["fname"] = $user["first_name"];
        $_SESSION["lname"] = $user["last_name"];
        $_SESSION["gender"] = $user["gender"];

        header("Location: ../{$role}/home.php");
    } else {
        // The password is incorrect

        header("Location: login_password.html?error=incorrectpassword");
        exit();
    }
    
} elseif (isset($_POST["add_pass"])) {

    $new_pass = $_POST["new_password"];

    $insert_query = "UPDATE $_SESSION[role] SET `password`  = '$new_pass' WHERE email = '$_SESSION[email]'";
    $insert = $conn->query($insert_query);

    if ($insert) {
        $query = "SELECT * FROM $_SESSION[role] WHERE email = '$_SESSION[email]'";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            $_SESSION["id"] = $user["id"];
            $_SESSION["fname"] = $user["first_name"];
            $_SESSION["lname"] = $user["last_name"];

            header("Location: ../{$_SESSION['role']}/home.php");
        }

    } else {
        echo "Error";
    }
}


?>