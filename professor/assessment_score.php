<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
<?php 
  include ("../includes/identity_nav.php"); 
  include ("menu_nav.html");
  include ("../includes/print_data_input.php")
  ?>

<section class="mx-auto grades min-vh-100 text-center py-5 px-3" id="courses">
  <?php
  print_header_choosenCourseSemester("white");
  ?>
  <a href="assessment_score-submit.php" class="btn btn-primary btn-lg me-5">Submit</a>
  <a href="assessment_score-view.php" class="btn btn-primary btn-lg">View</a>
   </section>

</body>
</html>