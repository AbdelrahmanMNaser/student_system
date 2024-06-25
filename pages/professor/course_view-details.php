<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <script src="/js/jquery-3.7.1.min.js"></script>
</head>
</head>

<body>
  <?php
  include("../../includes/identity_nav.php");
  include("menu_nav.html");
  include("../../includes/print_data_input.php");
  ?>

  <section class="mx-auto grades min-vh-100 text-center py-5 px-3" id="courses">
    <?php
    print_header_choosenCourseSemester("white");
    ?>
    <a href="assessment.php" class="btn btn-primary btn-lg">Assessment</a>

  </section>

</body>

</html>