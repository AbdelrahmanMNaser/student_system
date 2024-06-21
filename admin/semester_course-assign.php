<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Semester - Assign courses</title>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
  <?php
  include("../includes/identity_nav.php");
  include("menu_nav.html");
  include("../includes/alerts.php");
  ?>

  <script src="../js/customized_alert.js"></script>

  <section class="mx-auto grades text-center min-vh-100 py-5 px-3">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">Assign Courses for Semester</h2>
    </header>
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <form action="" method="post" class="form-group col-md-6 bg-dark text-white p-5 rounded">
          <div class="row g-2 mb-3">
            <div class="col-md-6">

              <select class="form-select text-center" name="course" id="course">
                <option value="" disabled selected>select course</option>

                <?php
                $retrieve = "SELECT id, name FROM course,, teaching ";
                $result = $conn->query($retrieve);

                while ($row = $result->fetch_assoc()) {
                  $course_id = $row["id"];
                  $course_name = $row["name"];

                ?>
                  <option value="<?php echo $course_id ?>"> <?php echo $course_name ?> </option>;
                <?php } ?>
              </select>

            </div>

            <div class="col-md-6">

              <select class="form-select" name="professor" id="professor">
                <option value="" disabled selected>select professor</option>
                <?php


                $retrieve = "SELECT Professor.id as prof_id , Professor.first_name as prof_fname , Professor.last_name as prof_lname , Department.name as dept_name
                        FROM   Professor, Department 
                        WHERE  Professor.department_id = Department.id
                        ORDER BY Department.name
                        ";

                $result = $conn->query($retrieve);

                while ($row = $result->fetch_assoc()) {
                  $prof_id = $row["prof_id"];
                  $prof_full_name = $row["prof_fname"] . " " . $row["prof_lname"];
                  $dept_name = $row["dept_name"];
                  echo "<option value = '$prof_id'>" . $prof_full_name . "&nbsp;&nbsp;|&nbsp;&nbsp;" . $dept_name . "</option>";
                }

                ?>
              </select>
            </div>

            <div class="text-center">
              <input class="btn btn-primary mt-4" type="submit" value="Add Professor" name="new_professor">
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
</body>

</html>

<?php
if (isset($_POST["course_semester"])) {
  $semester = $_SESSION["current_semester_id"];
  $course = $_POST["course"];
  $professor = $_POST["professor"];

  $insert_query = "INSERT INTO
    teaching (
        professor_id,
        course_id,
        semester_id
    )
    VALUES (
        '$professor',
        '$course',
        '$semester'
    )
    ";

  $insert = $conn->query($insert_query);

  if ($insert) {
    displayAlert("Courses & Professor", "Assigned", "success", "Successful!", "Successfully.\nDatabase Insertion Done!", "OK");
  } else {
    displayAlert("Course", "Assigned", "error", "Failed!", "\nPlease Try Again", "Try Again");
  }
}

?>