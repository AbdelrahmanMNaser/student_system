<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Home</title>

</head>

<body>
  <?php
  include("../../includes/identity_nav.php");
  include("menu_nav.html");
  include("../../includes/print_data_input.php");
  include("../../includes/current_semester.php");

  get_current_semester();
  ?>

  <section class="min-vh-100 home-student">
    <div class="container">
      <div class=" row align-items-center justify-content-center">
        <div class="col-md-12 text-center ftco-animate px-5">
          <h1 class=" mb-4 text-white">Welcome,
            <?php
            $gender = $conn->query("SELECT gender FROM admin WHERE id = '$_SESSION[id]' ")->fetch_assoc()["gender"];

            if ($gender == "Male") {
              echo "Mr.";
            } else {
              echo "Mrs.";
            }

            echo " " . $_SESSION['fname'];
            ?>
          </h1>
        </div>

      </div>
    </div>

    <?php var_dump($_SESSION) ?>

  </section>

</body>

</html>