<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?php echo $_SESSION["choosen_course"] ?></title>


<body>
  <?php
  include("../includes/identity_nav.php");
  include("menu_nav.html");
  include("../includes/print_data_input.php");
  ?>

  <section class="mx-auto final min-vh-100 text-center py-5 px-3" id="courses">
    <?php
    print_header_choosenCourseSemester("grey");
    ?>

    <a href="course_view-task.php">
      <button class="btn btn-primary btn-lg me-5">Tasks</button>
    </a>

    <a href="course_view-score.php">
      <button class="btn btn-primary btn-lg me-5">Scores</button>
    </a>

  </section>


</body>

</html>