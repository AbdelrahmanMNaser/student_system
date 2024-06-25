<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schedule - Add</title>

  <script src="../js/jquery-3.7.1.min.js"></script>
</head>

<body>
  <?php
  //header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  //header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
  //header("Pragma: no-cache");

  include("../includes/identity_nav.php");
  include("menu_nav.html");
  include("../includes/print_data_input.php");
  ?>

  <section class="mx-auto grades text-center min-vh-100 py-5 px-3">

    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">Add Schedule</h2>
    </header>

    <div class="container">
      <div class="row align-items-center justify-content-center">

        <form action="" id="course_form" class="form-group col-md-6 bg-dark text-white p-5 rounded" method="post">
          <div class="row mb-3">
            <label for="course" class="form-label">Course</label>
            <select name="course" id="course" class="form-select text-center" onchange="this.form.submit()">
              <option value="" disabled selected>select course</option>
              <?php
              print_courses("teaching", "admin");
              ?>
            </select>
          </div>

          <?php
          switch ($_SESSION["activity"]) {
            case "Lecture":
          ?>
              <div class="row mb-3">
                <div class="col">
                  <label for="activity" class="form-label">Activity</label>
                  <select name="activity" id="activity" class="form-select text-center" onchange="this.form.submit()">
                    <option value="" disabled selected>select activity</option>
                    <option value="Lecture">Lecture</option>

                    <?php
                    $retrieve = "SELECT assessment.type 
                              FROM 
                                assessment, assessment_onsite_schedule
                              WHERE
                                assessment_onsite_schedule.assessment_id = assessment.assess_id  
                                AND assessment_onsite_schedule.due_date IS NULL
                              ";

                    $result = $conn->query($retrieve);

                    while ($activity = $result->fetch_assoc()["type"]) {

                    ?>
                      <option value="<?php echo $activity ?>"><?php echo $activity ?></option>

                    <?php } ?>

                  </select>
                </div>
                <div class="col">
                  <label for="professor" class="form-label">Professor Name</label>
                  <select name="professor" id="professor" class="form-select">
                    <option value="" disabled select>select professor</option>
                    <?php
                    $retrieve = "SELECT 
                              professor.id,
                              professor.first_name as prof_fname,
                              professor.last_name as prof_lname

                              FROM
                                 professor, teaching

                              WHERE
                                  teaching.professor_id = professor.id
                              AND teaching.semester_id = '$_SESSION[current_semester_id]'
                              AND teaching.course_id = '$_SESSION[course]'
                              ";
                    $result = $conn->query($retrieve);
                    while ($row = $result->fetch_assoc()) :
                      $prof_id = $row["id"];
                      $prof_full_name = $row["prof_fname"] . " " . $row["prof_lname"];
                    ?>

                      <option value="<?php echo $prof_id ?>"><?php echo $prof_full_name ?></option>

                    <?php endwhile ?>
                  </select>
                </div>
              </div>

            <?php
              break;

            default:
            ?>
              <div class="row mb-3">
                <label for="activity" class="form-label">Activity</label>
                <select name="activity" id="activity" class="form-select text-center" onchange="this.form.submit()">
                  <option value="" disabled selected>select activity</option>
                  <option value="Lecture">Lecture</option>

                  <?php
                  $retrieve = "SELECT type 
                              FROM assessment 
                              JOIN assessment_onsite_schedule ON assessment.assess_id = assessment_onsite_schedule.assessment_id
                              WHERE 
                                    semester_id = '$_SESSION[current_semester_id]'
                                AND course_id = '$_SESSION[course]'
                                AND assessment_onsite_schedule.due_date IS NULL;
                  ";

                  $result = $conn->query($retrieve);

                  while ($activity = $result->fetch_assoc()["type"]) {

                  ?>
                    <option value="<?php echo $activity ?>"><?php echo $activity ?></option>

                  <?php } ?>

                </select>
              </div>
          <?php break;
          }
          ?>

          <div class="row mb-3">

            <div class="col-md-3">
              <label for="location" class="form-label">Location</label>
              <select name="location" id="location" class="form-select text-center" onchange="this.form.submit()">
                <option value="" disabled selected>select location</option>
                <?php
                $retrieve = "SELECT DISTINCT location FROM hall";
                $result = $conn->query($retrieve);

                while ($location = $result->fetch_assoc()["location"]) :

                ?>
                  <option value="<?php echo $location ?>"><?php echo $location ?></option>

                <?php endwhile ?>
              </select>
            </div>

            <div class="col-md-3">
              <label for="building" class="form-label">Building</label>
              <select name="building" id="building" class="form-select text-center" onchange="this.form.submit()">
                <option value="" disabled selected>select building</option>
                <?php
                $retrieve = "SELECT building FROM hall WHERE location = '$_SESSION[location]' ";
                $result = $conn->query($retrieve);

                while ($building = $result->fetch_assoc()["building"]) {

                ?>
                  <option value="<?php echo $building ?>"><?php echo $building ?></option>

                <?php
                } ?>
              </select>
            </div>
            <div class="col-md-3">
              <label for="roomType" class="form-label">Room</label>
              <select name="roomType" id="roomType" class="form-select text-center" onchange="this.form.submit()">
                <option value="">select room type</option>
                <option value="hall">Hall</option>
                <option value="lab">Lab</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="room" class="form-label"> <?php echo $_SESSION["roomType"] ?> </label>
              <select name="room" id="room" class="form-select" onchange="this.form.submit()">
                <option value="" disabled selected>select room</option>

                <?php
                $location = $_SESSION['location'];
                $building = $_SESSION['building'];
                $allowedTables = ['hall', 'lab'];
                $roomType = $_POST['roomType'];

                if (in_array($roomType, $allowedTables)) {
                  $retrieve = "SELECT id, capacity FROM `$roomType` WHERE `location` = '$location' AND `building` = '$building'";
                }

                $result = $conn->query($retrieve);

                while ($row = $result->fetch_assoc()) :
                  $room_id = $row["id"];
                  $room_capacity = $row["capacity"]
                ?>
                  <option value="<?php echo $room_id ?>"><?php echo $room_id ?> - <?php echo $room_capacity ?> Students</option>

                <?php endwhile ?>
              </select>
            </div>
          </div>
          <div class="row mb-3">

            <?php
            switch ($_SESSION["activity"]) {
              case "Lecture":
              case "Section":

            ?>
                <label for="day" class="form-label">Day</label>
                <select name="day" id="day" class="form-control">
                  <option value="" disabled selected>select day</option>
                  <option value="Saturday">Saturday</option>
                  <option value="Sunday">Sunday</option>
                  <option value="Monday">Monday</option>
                  <option value="Tuesuday">Tuesuday</option>
                  <option value="Wednesday">Wednesday</option>
                  <option value="Thursday">Thursday</option>
                  <option value="Friday">Friday</option>
                </select>

              <?php break;

              default:
              ?>
                <label for="date" class="form-label">Due Date</label>
                <input type="date" name="date" id="day" class="form-control text-center">

            <?php break;
            }
            ?>

          </div>
          <div class="row mb-3">

            <div class="col">
              <label for="start_time" class="form-label">Start Time</label>
              <input type="time" name="start_time" id="start_time" class="form-control">
            </div>

            <div class="col">
              <label for="end_time" class="form-label">End Time</label>
              <input type="time" name="end_time" id="end_time" class="form-control">
            </div>

          </div>
          <input class="btn btn-primary mt-4" type="submit" value="Add Schedule" name="new_schedule" id="new_schedule">
        </form>
      </div>
    </div>
  </section>

  <script src="../js/select_save_load.js"></script>
  <script>
    handleDataUpdate("course");
    handleDataUpdate("activity");
    handleDataUpdate("professor");
    handleDataUpdate("location");
    handleDataUpdate("building");
    handleDataUpdate("roomType");
    handleDataUpdate("room");
  </script>
</body>

</html>

<?php


if (isset($_POST["new_schedule"])) {

  $activity = $_SESSION["activity"];

  $semester_id = $_SESSION["current_semester_id"];
  $course_id = $_SESSION["course"];
  $room_no = $_SESSION["room"];
  $start_time = $_POST["start_time"];
  $end_time = $_POST["end_time"];

  if ($activity == "Lecture") {
    $prof_id = $_SESSION["professor"];
    $week_day = $_POST["day"];

    $insert_query = "INSERT INTO
        lecture_schedule(
            hall_no,
            course_id,
            professor_id,
            semester_id,
            week_day,
            start_time,
            end_time
        )
        VALUES(
            '$room_no',
            '$course_id',
            '$prof_id',
            '$semester_id',
            '$week_day',
            '$start_time',
            '$end_time'
        )
        ";
    $insert = $conn->query($insert_query);
  } else {
    $hall_id = $_POST["room"];
    $due_date = $_POST["date"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];

    $retrieve = "SELECT assess_id 
    FROM assessment 
    WHERE 
          type = '$activity' 
      AND semester_id = '$semester_id' 
      AND course_id = '$course_id'
    ";
    $result = $conn->query($retrieve);

    $assess_id = $result->fetch_assoc();

    $insert_query = "UPDATE assessment_onsite_schedule 
                     SET 
                      room_id = '$hall_no',
                      due_date = '$due_date', 
                      start_time = '$start_time', 
                      end_time = '$end_time'
                     WHERE 
                      assessment_id = '$assess_id'
    ";

    $insert = $conn->query($insert_query);
  }
}

?>