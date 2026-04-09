<?php
include "db.php";
$result = mysqli_query($conn, "SELECT * FROM contact_requests");
if(!$result)
{
    die("Query failed: " . mysqli_error($conn));
}
?>

<html>
<head>
  <title>Contact Requests</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h3>Contact / Help Requests</h3>
  <table class="table table-bordered table-striped mt-3">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Role</th>
        <th>Email</th>
        <th>Issue</th>
        <th>Message</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php if(mysqli_num_rows($result) > 0){ ?>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['role'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['issue'] ?></td>
            <td><?= $row['message'] ?></td>
            <td><?= $row['created_at'] ?></td>
          </tr>
        <?php } ?>
        <?php } else { ?>
          <tr>
           <td colspan="7" class="text-center text-danger">No requests found</td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
