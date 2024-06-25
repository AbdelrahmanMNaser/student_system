<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Department - View</title>
  <script src="../js/confirmation_alert.js"></script>
  <script src="../js/customized_alert.js"></script>
</head>

<body>
  <?php
  include("../includes/identity_nav.php");
  include("menu_nav.html");
  include("../includes/delete_item.php");
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
        <th colspan="2">Actions</th>
      </thead>
      <tbody>

        <?php
        $retrieve = "SELECT 
                      id, 
                      name,
                      (SELECT COUNT(*) FROM student WHERE student.department_id = department.id) AS num_students,
                      (SELECT COUNT(*) FROM professor WHERE professor.department_id = department.id) AS num_profs
                    FROM 
                      department
                        ";

        $result = $conn->query($retrieve);
        while ($row = $result->fetch_assoc()) :
          $dept_id = $row["id"];
          $dept_name = $row["name"];
          $num_students = $row["num_students"];
          $num_profs = $row["num_profs"];
        ?>
          <tr>
            <td><?php echo $dept_name ?></td>
            <td><?php echo $num_profs ?></td>
            <td><?php echo $num_students ?></td>

            <td>
              <form action="department_add.php" method="post" onsubmit="confirmEdit(event, 'department of <?php echo $dept_name ?>');">
                <input type="hidden" name="dept_name" value="<?php echo $dept_name ?>">
                <input type="hidden" name="edit" value="<?php echo $dept_id ?>">
                <button type="submit" class="btn btn-warning">
                  <i class="fas fa-edit"></i>
                </button>
              </form>
            </td>

            <td>
              <form action="" method="post" onsubmit="return confirmRemove(event, 'department of <?php echo $dept_name ?>');">
                <input type="hidden" name="delete" value="<?php echo $dept_id ?>">
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
      showAlert("Edit Successful", "Department data is editted Successfully", "info", "OK");
    }
  </script>

</body>

</html>
<?php
if (isset($_POST["delete"])) {
  $pk_value = $_POST["delete"];
  delete_Row("department", "id", $pk_value);
}
?>