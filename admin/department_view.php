<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Department - View</title>
</head>

<body>
  <?php
  include("../includes/identity_nav.php");
  include("menu_nav.html");
  ?>

  <section class="mx-auto admin text-center min-vh-100 py-5 px-3">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">View Department</h2>
    </header>

    <table class="table table-bordered">
      <thead>
        <th>Department Name</th>
        <th>Number of Professors</th>
        <th>Number of Students</th>
      </thead>
      <tbody>

        <?php
        $retrieve = "SELECT department.name AS dept_name,
                        (SELECT COUNT(*) FROM student WHERE student.department_id = department.id) AS num_students,
                        (SELECT COUNT(*) FROM professor WHERE professor.department_id = department.id) AS num_profs
                        FROM department
                        ";

        $result = $conn->query($retrieve);
        while ($row = $result->fetch_assoc()) :
          $dept_name = $row["dept_name"];
          $num_students = $row["num_students"];
          $num_profs = $row["num_profs"];
        ?>
          <tr>
            <td> <?php echo $dept_name ?> </td>
            <td> <?php echo $num_profs ?> </td>
            <td> <?php echo $num_students ?> </td>
          </tr>
        <?php endwhile ?>
      </tbody>
    </table>
  </section>
</body>

</html>