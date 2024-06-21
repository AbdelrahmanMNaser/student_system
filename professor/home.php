<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>

</head>
</head>

<body>

  <?php
  include("../includes/identity_nav.php");
  include("menu_nav.html");
  include("../includes/current_semester.php");

  get_current_semester();

  ?>

  <section class=" min-vh-100 home-student">
    <div class="container">
      <div class=" row align-items-center justify-content-center">
        <div class="col-md-12 text-center ftco-animate px-5">
          <h1 class=" mb-4 text-white">Welcome, <?php echo " " . $_SESSION['fname']; ?> </h1>

          <?php
          $user_id = $_SESSION['id'];
          $retrieve = "SELECT department.name as dept_name FROM professor, department WHERE department.id = professor.department_id AND professor.id =  $user_id";
          $result = $conn->query($retrieve);
          if ($result->num_rows > 0) {
            $department_name = $result->fetch_assoc()["dept_name"];
          }
          ?>
          
          <p class="text-white">Alexandria University, Department of
            <span class=" fw-bold"><?php echo $department_name; ?></span>
          </p>

        </div>
      </div>
    </div>
    </div>

  </section>

  <footer>
    <div class=" w-100 py-3 text-center bg-primary">
      <button class=" btn rounded-pill btn-contact">Contact Us</button>
    </div>
  </footer>


</body>

</html>