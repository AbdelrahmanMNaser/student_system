<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assessment | Score - Submit</title>  
  
  <script src="/js/jquery-3.7.1.min.js"></script>


</head>

<body>
  <?php
  include("../../includes/identity_nav.php");
  include("menu_nav.html");
  include("../../includes/print_data_input.php")
  ?>

  <section class="mx-auto grades min-vh-100 text-center py-5 px-3" id="courses">
    <?php print_header_choosenCourseSemester("white") ?>

    <div class="d-flex align-items-center mb-3 justify-content-center">
      <form action="" method="post">
        <select name="category" id="category" class="form-select text-center" onchange="this.form.submit()">
          <option value="" disabled selected>Select Category</option>
          <?php
          $retrieve = "SELECT DISTINCT Assessment.type
            FROM
              Assessment, teaching

            WHERE
                  teaching.course_id   =  Assessment.course_id
              AND teaching.semester_id =  Assessment.semester_id
              AND teaching.semester_id = '$_SESSION[semester]' 
              AND teaching.course_id   = '$_SESSION[choosen_course_id]'
            ";

          $result = $conn->query($retrieve);

          while ($type = $result->fetch_assoc()["type"]) {
            echo "<option value = '$type'>" . $type . "</option>";
          }
          ?>

        </select>
      </form>
    </div>

    <?php if ($_SESSION["category"]) :
    ?>

      <form action="" method="post">
        <label for="student_id" class="col-form-label text-white mt-3">Student ID:</label>
        <div style="display: flex; align-items: center; justify-content: center;">
          <input type="text" name="student_id" id="student_id" class="form-control col-md-6 w-15 text-center">
          <span style="position: absolute; color: white; font-size: 16px; margin-left: 500px;" id="msg-enter-id"></span>
        </div>
      </form>

      <?
      $retrieve = "SELECT
      DISTINCT
        student.id as std_id,
        student.first_name as std_fname,
        student.last_name as std_lname
      
      FROM
        student, enrollment

      WHERE
            student.id = enrollment.student_id
        AND student.id = '$_SESSION[student_id]'
        AND enrollment.semester_id = '$_SESSION[semester]'
        AND enrollment.course_id = '$_SESSION[choosen_course_id]'
      ";


      $result = $conn->query($retrieve);

      if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $id = $data["std_id"];
        $name = $data["std_fname"] . " " . $data["std_lname"];

        $retrieve = "SELECT  
            assessment_score.score as std_score,
            assessment_score.assessment_id as assess_id

          FROM 
            assessment, assessment_score 
          WHERE 
                assessment.assess_id = assessment_score.assessment_id
            AND assessment.type = '$_SESSION[category]'
            ";


        $result = $conn->query($retrieve);
        $row = $result->fetch_assoc();
        $assess_id = $row["assess_id"];
        $prev_score = $row["std_score"];


        if ($prev_score == null) {
          $scoreField =  print_score_input();
        } else {
          $edit_icon = print_edit_icon();
          $scoreField = $prev_score . $edit_icon;
        }

      ?>

        <table class="table table-bordered mt-5">
          <thead>
            <th>Student ID</th>
            <th>Name</th>
            <th class='col'>Score</th>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $id; ?></td>
              <td><?php echo $name; ?></td>
              <td class="col">
                <form action="" method="post">
                  <center>
                    <?php echo $scoreField; ?>
                  </center>
              </td>
            </tr>
          </tbody>
        </table>

        <span id="msg-score" style="color: white; font-size: 25px;"></span>

      <?php
      } else {
        echo "<p style='margin-top: 50px; font-size: 25px; color: white;' >" . "Student Not Found" . "</p>";
      }
      ?>
    <?php endif ?>

    <script src="/js/select_save_load.js"></script>
    <script>
      handleDataUpdate("category");
      handleDataUpdate("student_id");
    </script>
    <script src="/js/show_score_input.js"></script>
    <script src="/js/handle_id_score_input.js"></script>

  </section>


</body>

</html>
<?php
if (isset($_POST["score"])) {
  $insert_query = "UPDATE assessment_score SET score = '$_POST[score]'
                     WHERE  assessment_id = '$assess_id'";

  $insert = $conn->query($insert_query);
}
?>