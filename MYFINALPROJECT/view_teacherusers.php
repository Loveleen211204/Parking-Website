<?php
include "db.php";
$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'Teacher'");
if(!$result)
{
    die("Query failed: " . mysqli_error($conn));
}
?>

<html>
<head>
  <title>All Teacher Users</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h3>Registered Teachers</h3>
  <table class="table table-bordered table-striped mt-3">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>EmpId</th>
        <th>Department</th>
        <th>Vehicle No</th>
        <th>Vehicle Type</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php if(mysqli_num_rows($result) > 0){ ?>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['empid'] ?></td>
            <td><?= $row['department'] ?></td>
            <td><?= $row['vehicle'] ?></td>
            <td><?=$row['vehicle_type']?></td>
            <td><?= $row['created_at'] ?></td> 
          </tr>
        <?php } ?>
        <?php } else { ?>
        <tr>
          <td colspan="8" class="text-center text-danger">No users found</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
