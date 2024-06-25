<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Course | View</title>
  <script src="/js/jquery-3.7.1.min.js"></script>
</head>

<body>
  <?php
  include("../../includes/identity_nav.php");
  include("menu_nav.html");
  include("../../includes/print_data_input.php");
  ?>

  <section class="mx-auto grades min-vh-100 text-center py-5 px-3" id="courses">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">View Courses</h2>
    </header>

    <form action="" id="course_view" method="post">
      <select class="form-select w-15 mx-auto mb-4" id="semester" name="semester" onchange="this.form.submit()">
        <option value="" disabled selected>Select Semester</option>
        <?php print_semesters("teaching", "professor") ?>
      </select>
    </form>

    <table class="table table-bordered">
      <thead>
        <th>Course Code</th>
        <th>Course Name</th>
        <th>Number of Students</th>
      </thead>

      <tbody>
        <?php
        if (isset($_POST["semester"])) {
          $_SESSION["semester"] = $_POST["semester"];
        }

        $choosen_semester = $_SESSION["semester"];


        $retrieve = "SELECT
        DISTINCT
          course.id as crs_code,
          course.name as crs_name,
          COUNT(enrollment.student_id) as std_count
        FROM
          course, teaching, enrollment
        WHERE
              teaching.course_id = course.id
          AND teaching.course_id = enrollment.course_id
          AND teaching.semester_id = enrollment.semester_id
          AND teaching.professor_id = '$_SESSION[id]'
          AND teaching.semester_id = $choosen_semester
        GROUP BY
          course.id
      ";

        $result = $conn->query($retrieve);
        while ($row = $result->fetch_assoc()) :
          $course_code = $row["crs_code"];
          $course_name = $row["crs_name"];
          $students_count = $row["std_count"];
        ?>

          <tr>
            <td><?php echo $course_code ?></td>
            <td>
              <a href="course_view-details.php" class="course-link" data-course-name="<?php echo $course_name ?>" data-course-id="<?php echo $course_code ?>">
                <?php echo $course_name ?>
              </a>
            </td>
            <td><?php echo $students_count ?></td>
          </tr>
        <?php endwhile ?>

      </tbody>
    </table>

  </section>

  <script src="/js/select_save_load.js"></script>
  <script>
    handleDataUpdate("semester");
  </script>

  <script src="/js/click_save_load.js"></script>

  <script>
    handleCourseLinkClick('.course-link');
  </script>

</body>

</html>
<?php
if (isset($_POST["course_id"]) && isset($_POST["course_name"])) {
  $_SESSION["choosen_course_id"] = $_POST["course_id"];
  $_SESSION["choosen_course_name"] = $_POST["course_name"];
}

?>