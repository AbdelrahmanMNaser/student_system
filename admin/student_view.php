<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student - View</title>
</head>

<body>
  <?php
  include("../includes/identity_nav.php");
  include("menu_nav.html");
  include("../includes/scores_grades.php");
  ?>

  <section class="mx-auto admin text-center min-vh-100 py-5 px-3">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">View Student</h2>
    </header>

    <table class="table table-bordered">
      <thead>
        <th>ID</th>
        <th>Student Name</th>
        <th>Gender</th>
        <th>Age</th>
        <th>City</th>
        <th>E-mail</th>
        <th>Phone(s)</th>
        <th>Register Date</th>
        <th>Department Name</th>
        <th>Level</th>
        <th colspan="2">Actions</th>
      </thead>
      <tbody>

        <?php
        $retrieve = "SELECT student.*, 
                      (DATE_FORMAT(FROM_DAYS(DATEDIFF(now(), student.birth_date)), '%Y')+0) AS age, 
                      department.name AS dept_name, 
                      GROUP_CONCAT(student_phone.phone_number SEPARATOR ' | ') AS phone
                    FROM 
                      student
                    LEFT JOIN 
                      student_phone ON student.id = student_phone.student_id
                    INNER JOIN 
                      department ON student.department_id = department.id
                    GROUP BY 
                      student.id
            ";

        $result = $conn->query($retrieve);

        while ($row = $result->fetch_assoc()) :
          $id = $row["id"];
          $fname = $row["first_name"];
          $lname = $row["last_name"];
          $full_name =  $fname . " " . $lname;
          $birth = $row["birth_date"];
          $age = $row["age"];
          $gender = $row["gender"];
          $city = $row["city"];
          $street = $row["street"];
          $email = $row["email"];
          $phone = $row["phone"];
          $dept_name = $row["dept_name"];
          $register_date = $row["registration_date"];
          $level = calculate_student_level(calculate_total_credits($id));
        ?>
          <tr>
            <td> <?php echo $id ?> </td>
            <td> <?php echo $full_name ?> </td>
            <td> <?php echo $gender ?> </td>
            <td> <?php echo $age ?> </td>
            <td> <?php echo $email ?> </td>
            <td> <?php echo $phone ?> </td>
            <td> <?php echo $register_date ?> </td>
            <td> <?php echo $dept_name ?> </td>
            <td> <?php echo $level ?> </td>

            <td>
              <form action="student_add.php" method="post" onsubmit="confirmEdit(event, 'Student <?php echo $full_name ?> - ID: <?php echo $id ?>');">
                <input type="hidden" name="edit_fname" value="<?php echo $fname ?>">
                <input type="hidden" name="edit_lname" value="<?php echo $lname ?>">
                <input type="hidden" name="edit_bdate" value="<?php echo $birth ?>">
                <input type="hidden" name="edit_gender" value="<?php echo $gender ?>">
                <input type="hidden" name="edit_city" value="<?php echo $city ?>">
                <input type="hidden" name="edit_street" value="<?php echo $street ?>">
                <input type="hidden" name="edit_email" value="<?php echo $email ?>">
                <input type="hidden" name="edit_dept_name" value="<?php echo $dept_name ?>">
                <input type="hidden" name="edit_id" value="<?php echo $id ?>">

                <button type="submit" class="btn btn-warning">
                  <i class="fas fa-edit"></i>
                </button>
              </form>
            </td>

            <td>
              <form action="" method="post" onsubmit="confirmRemove(event, 'Student <?php echo $full_name ?> - ID: <?php echo $id ?>');">
                <input type="hidden" name="delete" value="<?php echo $num ?>">
                <button type="submit" class="btn btn-danger">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>

          </tr>
        <?php endwhile ?>
      </tbody>
    </table>

  </section>

  <script>
    if (new URLSearchParams(window.location.search).has("edit")) {
      showAlert("Edit Successful", "Student data is editted Successfully", "info", "OK");
    }
  </script>
</body>

</html>