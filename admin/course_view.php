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
  include("../includes/delete_item.php");
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
        <th colspan="2">Actions</th>
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

            <td>
              <form action="course_add.php" method="post" onsubmit="confirmEdit(event, '<?php echo $course_name ?> Course');">
                <input type="hidden" name="crs_name" value="<?php echo $course_name ?>">
                <input type="hidden" name="crs_credit" value="<?php echo $course_credits ?>">
                <input type="hidden" name="crs_description" value="<?php echo $course_description ?>">
                <input type="hidden" name="pre_req" value="<?php echo $pre_requisites ?>">

                <input type="hidden" name="edit" value="<?php echo $course_id ?>">
                <button type="submit" class="btn btn-warning">
                  <i class="fas fa-edit"></i>
                </button>
              </form>
            </td>

            <td>
              <form action="" method="post" onsubmit="confirmRemove(event, '<?php echo $course_name ?> Course');">
                <input type="hidden" name="delete" value="<?php echo $course_id ?>">
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
      showAlert("Edit Successful", "Course data is editted Successfully", "info", "OK");
    }
  </script>
</body>

</html>

<?php
if (isset($_POST["delete"])) {
  $pk_value = $_POST["delete"];
  delete_Row("course", "id", $pk_value);
}
?>