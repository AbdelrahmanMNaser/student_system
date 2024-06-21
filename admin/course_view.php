<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course - View</title>
</head>

<body>
  <?php
  include("../includes/identity_nav.php");
  include("menu_nav.html");
  ?>

  <section class="mx-auto admin text-center min-vh-100 py-5 px-3">


    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">View Courses</h2>
    </header>

    <table class="table table-bordered">
      <thead class="text-center">
        <th>Course Code</th>
        <th>Course Name</th>
        <th>Credits</th>
        <th>Pre-requisit</th>
        <th>Description</th>
      </thead>
      <tbody>

        <?php
        $retrieve = "SELECT 
            c1.name AS course_name, 
            c1.id AS course_id, 
            c1.credit AS course_credits, 
            c1.description as course_description,
            GROUP_CONCAT(c2.name SEPARATOR ', ') AS pre_requisite_names
            
            FROM 
                course c1
            
            LEFT JOIN course_pre_requisit cp ON c1.id = cp.course_id
            LEFT JOIN course c2 ON cp.pre_requisit_id = c2.id

            GROUP BY
                c1.id
            ";
        $result = $conn->query($retrieve);
        while ($row = $result->fetch_assoc()) :
          $course_name = $row["course_name"];
          $course_id = $row["course_id"];
          $course_description = $row["course_description"];
          $course_credits = $row["course_credits"];
          $pre_requisites = $row["pre_requisite_names"];
        ?>
          <tr>
            <td> <?php echo $course_id ?> </td>
            <td> <?php echo $course_name ?> </td>
            <td> <?php echo $course_credits ?> </td>
            <td> <?php echo $pre_requisites ?> </td>
            <td> <?php echo $course_description ?> </td>

          </tr>
        <?php endwhile ?>
      </tbody>
    </table>
  </section>
</body>

</html>