<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Professor - View</title>
</head>

<body>
  <?php
  include("../includes/identity_nav.php");
  include("menu_nav.html");
  ?>

  <section class="mx-auto admin text-center min-vh-100 py-5 px-3">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">View Professor</h2>
    </header>


    <table class="table table-bordered">
      <thead>
        <th>Professor Name</th>
        <th>Gender</th>
        <th>Age</th>
        <th>E-mail</th>
        <th>Phone Number</th>
        <th>Department Name</th>
      </thead>
      <tbody>

        <?php
        $retrieve = "SELECT professor.*, 
            (DATE_FORMAT(FROM_DAYS(DATEDIFF(now(), professor.birth_date)), '%Y')+0) AS age, 
            department.name AS dept_name, 
            GROUP_CONCAT(professor_phone.phone_number SEPARATOR ' | ') AS phone

            FROM professor, department, professor_phone
            WHERE professor.department_id = department.id AND professor.id = professor_phone.professor_id
            GROUP BY professor.id
            ";

        $result = $conn->query($retrieve);

        while ($row = $result->fetch_assoc()) :
          $name = $row["first_name"] . " " . $row["last_name"];
          $gender = $row["gender"];
          $age = $row["age"];
          $email = $row["email"];
          $phone = $row["phone"];
          $dept_name = $row["dept_name"];
        ?>
          <tr>
            <td> <?php echo $name ?> </td>
            <td> <?php echo $gender ?> </td>
            <td> <?php echo $age ?> </td>
            <td> <?php echo $email ?> </td>
            <td> <?php echo $phone ?> </td>
            <td> <?php echo $dept_name ?> </td>
          </tr>
        <?php endwhile ?>
      </tbody>
    </table>
  </section>
</body>

</html>