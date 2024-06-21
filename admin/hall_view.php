<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hall - View</title>
</head>

<body>
  <?php
  include("../includes/identity_nav.php");
  include("menu_nav.html");
  ?>

  <section class="mx-auto admin text-center min-vh-100 py-5 px-3">
    <header class="header-adj2 mb-5">
      <h2 class=" f-header fs-1 fw-bold text-white">View Hall</h2>
    </header>
    <table class="table table-bordered">
      <thead>
        <th>Hall no.</th>
        <th>Location</th>
        <th>Building</th>
        <th>Floor</th>
        <th>Capacity</th>
      </thead>
      <tbody>

        <?php
        $retrieve = "SELECT * from Hall";

        $result = $conn->query($retrieve);
        while ($row = $result->fetch_assoc()) :
          $num = $row["hall_no"];
          $location = $row["location"];
          $building = $row["building"];
          $floor = $row["floor"];
          $capacity = $row["capacity"];
        ?>

          <tr>
            <td> <?php echo $num ?> </td>
            <td> <?php echo $location ?> </td>
            <td> <?php echo $building ?> </td>
            <td> <?php echo $floor ?> </td>
            <td> <?php echo $capacity ?> </td>
          </tr>
        <?php endwhile ?>
      </tbody>
    </table>
  </section>
</body>

</html>