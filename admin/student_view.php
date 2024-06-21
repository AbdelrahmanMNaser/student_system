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
      <h2 class=" f-header fs-1 fw-bold text-white">View Semester</h2>
    </header>

    <table class="table table-bordered">
      <thead>
        <th>Student Name</th>
        <th>Gender</th>
        <th>Age</th>
        <th>E-mail</th>
        <th>Phone Numbers</th>
        <th>Registration Date</th>
        <th>Department Name</th>
        <th>Level</th>
      </thead>
      <tbody>

        <?php
        $retrieve = "SELECT student.*, 
            (DATE_FORMAT(FROM_DAYS(DATEDIFF(now(), student.birth_date)), '%Y')+0) AS age, 
            department.name AS dept_name, 
            GROUP_CONCAT(student_phone.phone_number SEPARATOR ' | ') AS phone

            FROM student, department, student_phone
            WHERE student.department_id = department.id AND student.id = student_phone.student_id
            GROUP BY student.id
            ";

        $result = $conn->query($retrieve);

        while ($row = $result->fetch_assoc()) :
          $id = $row["id"];
          $name = $row["first_name"] . " " . $row["last_name"];
          $gender = $row["gender"];
          $age = $row["age"];
          $email = $row["email"];
          $phone = $row["phone"];
          $dept_name = $row["dept_name"];
          $register_date = $row["registration_date"];
          $level = calculate_student_level(calculate_total_credits($id));
        ?>
          <tr>
            <td> <?php echo $name ?> </td>
            <td> <?php echo $gender ?> </td>
            <td> <?php echo $age ?> </td>
            <td> <?php echo $email ?> </td>
            <td> <?php echo $phone ?> </td>
            <td> <?php echo $register_date ?> </td>
            <td> <?php echo $dept_name ?> </td>
            <td> <?php echo $level ?> </td>
          </tr>
        <?php endwhile ?>
      </tbody>
    </table>
  </section>
</body>

</html>