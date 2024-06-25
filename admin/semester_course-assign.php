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
                $retrieve = "SELECT id, name
                 FROM 
                  course 
                  WHERE 
                    id NOT IN 
                      (SELECT course_id FROM teaching WHERE semester_id = '$_SESSION[current_semester_id]')";
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

              <div class="mb-3">
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="professorDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    Select Professor(s)
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="professorDropdown">
                    <?php

                    $retrieve = "SELECT 
              Professor.id AS prof_id, 
              Professor.first_name AS prof_fname , 
              Professor.last_name AS prof_lname, 
              Department.name AS dept_name
              FROM   
                Professor, Department 
              WHERE  
                Professor.department_id = Department.id
              ORDER BY 
                Department.name
              ";

                    $result = $conn->query($retrieve);

                    $lastDept = null;
                    if ($result) {
                      while ($row = $result->fetch_assoc()) {
                        $prof_id = $row["prof_id"];
                        $prof_full_name = $row["prof_fname"] . " " . $row["prof_lname"];
                        $dept_name = $row["dept_name"];

                        if ($lastDept != $dept_name) {
                          if ($lastDept != null) {
                            echo "</ul></li>"; // Close previous optgroup
                          }
                          echo "<li class='dropdown-header'>$dept_name</li><li><ul class='list-unstyled'>";
                          $lastDept = $dept_name;
                        }

                        echo "<li>
                  <label class='form-check-label'>
                    <input value='$prof_id' type='checkbox' name='professor[]' class='form-check-input'>
                    $prof_full_name
                  </label>
                </li>";
                      }
                      if ($lastDept != null) {
                        echo "</ul></li>"; // Close last optgroup
                      }
                    } else {
                      echo "<li class='dropdown-header'>Error fetching data.</li>";
                    }

                    ?>
                  </ul>
                </div>
                <input type="hidden" name="selected_professors" id="selected_professors">
              </div>
            </div>

            <div class="text-center">
              <input class="btn btn-primary mt-4" type="submit" value="Add Professor" name="new_professor">
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
  const checkboxes = document.querySelectorAll('input[name="professor[]"]');
  const selectedProfessorsInput = document.getElementById('selected_professors');

  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
      const selectedProfessorIds = Array.from(document.querySelectorAll('input[name="professor[]"]:checked')).map(el => el.value);
      selectedProfessorsInput.value = selectedProfessorIds.join(',');
    });
  });
});
  </script>
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