<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University</title>

  <script src="js/jquery-3.7.1.min.js"></script>

</head>

<body>
  <?php
  include("../../includes/identity_nav.php");
  include("menu_nav.html");
  include("../../includes/print_data_input.php")
  ?>

  <section class="mx-auto grades min-vh-100 text-center text-white py-5 px-3" id="courses">
    <?php print_header_choosenCourseSemester("white"); ?>

    <div class="container">
      <div class="row align-items-center justify-content-center">
        <form action="" method="post" class="form-group col-md-4" enctype="multipart/form-data">

          <div class="mb-3">

            <label for="category" class="form-label">Category</label>
            <select class="form-select text-center" name="category" id="category" onchange="this.form.submit()" required>
              <option value="" disabled selected>select category</option>
              <optgroup label="Coursework">
                <option value="Assignment">Assignment</option>
                <option value="Quiz">Quiz</option>
                <option value="Project">Project</option>
                <option value="Practical">Practical</option>
                <option value="Oral">Oral</option>
              </optgroup>
              <optgroup label="Exams">
                <option value="Midterm">Midterm</option>
                <option value="Final">Final</option>
              </optgroup>

            </select>
          </div>
          <?php if ($_SESSION["category"]) : ?>

            <?php
            switch ($_SESSION["category"]) {
              case "Assignment":
              case "Quiz":
              case "Project":
            ?>
                <div class="mb-3">
                  <label for="receive_method" class="form-label mt-3">Receive Method</label>
                  <select name="receive_method" id="receive_method" class="form-select text-center" onchange="this.form.submit()" required>
                    <option value="" disabled selected>Select receive method</option>
                    <option value="On-site">On-site</option>
                    <option value="Online">Online</option>
                  </select>
                </div>

                <?php if ($_SESSION["receive_method"] == "Online") : ?>

                  <div class="row">
                    <div class="<?php echo ($_SESSION["upload_method"] == "Form") ? 'col' : 'col-md-12'; ?>">
                      <label for="upload_method" class="form-label mt-3">Upload Method</label>
                      <select name="upload_method" id="upload_method" class="form-select text-center" onchange="this.form.submit()" required>
                        <option value="" disabled selected>Select upload method</option>
                        <option value="Form">Form</option>
                        <option value="E-mail">E-mail</option>
                      </select>
                    </div>

                    <?php if ($_SESSION["upload_method"] == "Form") : ?>
                      <div class="col">
                        <label for="form_link" class="form-label mt-3">Form Link</label>
                        <input type="text" name="form_link" id="form_link" class="form-control" required>
                      </div>
                    <?php endif; ?>
                  </div>

                  <div class="row mb-3">
                    <div class="col">
                      <label for="due" class="form-label mt-3">Due Date:</label>
                      <input type="date" name="due_date" id="due" class="form-control text-center">
                    </div>
                  </div>

                  <div class="row mb-3">

                    <?php if ($_SESSION["category"] == "Quiz") :

                    ?>
                      <div class="col">
                        <label for="start" class="form-label mt-3">Start Time</label>
                        <input type="time" class="form-control text-center" name="start_time" id="start">
                      </div>

                    <?php endif ?>

                    <div class="col">
                      <label for="end" class="form-label mt-3">End Time</label>
                      <input type="time" class="form-control text-center" name="end_time" id="end">
                    </div>

                  </div>
                <?php endif; ?>

            <?php
                break;
            }
            ?>

            <div id="attachArea" class="row mb-3">
              <!-- File Upload inputs will be added here -->
            </div>

            <p id="attach" style="color: blue; cursor: pointer;" onclick="displayAttachement()">
              <i class="fa fa-paperclip"></i> Attach Files
            </p>

            <div class="mb-3">
              <div class="col"> <label for="description" class="form-label mt-3">Description:</label>
                <textarea class="form-control text-center" placeholder="Tell Students Something About <?php echo $_SESSION['category'] ?>" name="description" id="description" cols="5" rows="5"></textarea>
              </div>

            </div>

            <div class="mb-3">
              <label for="maxNumber" class="form-label text-white mt-3">Maximum Score:</label>
              <input type="number" name="max_score" id="maxNumber" min="1" max="60" class="form-control text-center" required>
            <?php endif ?>
            </div>
            <input class="btn btn-primary mt-4" type="submit" value="Add Assessment" name="new_assess" id="new_schedule">

        </form>
      </div>

    </div>
  </section>

  <script src="js/select_save_load.js"></script>
  <script>
    handleDataUpdate("category");
    handleDataUpdate("receive_method");
    handleDataUpdate("upload_method");
  </script>

  <script src="js/show_attachement.js"></script>

</body>

</html>

<?php
if (isset($_POST["new_assess"])) {
  $type = $_SESSION["category"];

  $onsite_categories = array("Practical", "Oral", "Midterm", "Final");

  if (in_array($type, $onsite_categories)) {
    $format = "Onsite";
  } else {
    $format = $_SESSION["receive_method"];
  }

  $max_score = $_POST["max_score"];
  $description = $_POST["description"];

  $insert_query = "INSERT INTO 
  assessment (
    semester_id,
    course_id,
    type,
    format,
    max_score,
    description
  )
  VALUES (
    '$_SESSION[semester]',
    '$_SESSION[choosen_course_id]',
    '$type',
    '$format',
    '$max_score',
    '$description'
  )
  ";

  $insert = $conn->query($insert_query);

  if ($insert) {
    $assess_id = $conn->insert_id;

    switch ($format) {
      case "On-site":
        $insert_schedule_query = "INSERT INTO assessment_onsite_schedule (assessment_id) VALUES ('$assess_id') ";
        $insert_schedule = $conn->query($insert_schedule_query);
        break;

      case "Online":
        $due_date = $_POST["due_date"];
        $end_time = $_POST["end_time"];

        $insert_schedule_query = "INSERT INTO 
        assessment_online_schedule (
          assessment_id,
          due_date,
          end_time
        ) 
        VALUES (
          '$assess_id',
          '$due_date',
          '$end_time'
        ) 
        ";

        $insert_schedule = $conn->query($insert_schedule_query);

        if (isset($_POST["start_time"])) {
          $start_time = $_POST["start_time"];

          $update_st_query = "UPDATE assessment_online_schedule SET start_time = '$start_time' WHERE assessment_id = '$assess_id'";
          $update_st = $conn->query($update_st_query);
        }

        break;
    }

    if (isset($_POST["upload_method"])) {

      switch ($_POST["upload_method"]) {
        case "E-mail":
          $hyperlink = $_SESSION["email"];
          break;

        case "Form":
          $hyperlink = $_POST["form_link"];
          break;
      }

      $insert_link_query = "INSERT INTO 
      assessment_link (
        assessment_id,
        professor_id,
        link
      )
      VALUES (
        '$assess_id',
        '$_SESSION[id]',
        '$hyperlink'
      )
      ";

      $insert_link = $conn->query($insert_link_query);
    }

    if (!empty($_FILES["file"]["name"])) {
      $targetDir = "uploads/";
      $fileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
      $fileName = uniqid() . " " . $_FILES["file"]["name"];
      $targetFilePath = $targetDir . uniqid() . "." . $fileType;

      // Get current date and time 
      $upload_date = date("Y-m-d H:i:s");

      $allowed_formats = array('doc', 'docx', 'pdf');
      if (in_array($fileType, $allowed_formats)) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
          $insert_file_query = "INSERT INTO 
                assessment_file (
                  assessment_id,
                  professor_id,
                  file_name, 
                  file_path, 
                  upload_date
              ) 
              VALUES (
                '$assess_id',
                '$_SESSION[id]',
                '$fileName',
                '$targetFilePath',
                '$upload_date'
              )
            ";

          $insert_file = $conn->query($insert_file_query);
        }
      }
    }
  }
}
?>