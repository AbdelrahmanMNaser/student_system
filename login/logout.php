<?php
session_start();
if (isset($_GET["logout"])) {
   
    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    echo "You are Logged Out";

    session_destroy();
    header("location: ../index.html");
    exit();
}
?>