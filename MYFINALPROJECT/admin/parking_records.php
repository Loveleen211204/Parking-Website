<?php
require_once 'config.php';
requireLogin();

// Filters
$date   = isset($_GET['date'])   ? mysqli_real_escape_string($conn, $_GET['date'])   : '';
$role   = isset($_GET['role'])   ? mysqli_real_escape_string($conn, $_GET['role'])   : '';
$status = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$where = "WHERE 1=1";
if ($date)   $where .= " AND DATE(ph.entry_time)='$date'";
if ($role && $role !== 'all') $where .= " AND u.role='$role'";
if ($status == 'inside') $where .= " AND ph.exit_time IS NULL";
    elseif ($status == 'exited') 
    $where .= " AND ph.exit_time IS NOT NULL";
// 🔍 Search filter
if (!empty($search)) {

    if (is_numeric($search)) {
        // exact ID match
        $where .= " AND u.id = $search";
    } else {
        // name or email match
        $where .= " AND (
            u.name LIKE '%$search%' OR
            u.email LIKE '%$search%'
        )";
    }

}
$result = mysqli_query($conn, "SELECT ph.*, u.name, u.email, u.role 
 FROM parking_history ph 
 JOIN users u ON ph.user_id=u.id 
 $where 
 ORDER BY ph.entry_time DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Entry/Exit Records – ParkAdmin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
 <?php include 'includes/sidebar.php'; ?>
  <div class="main-content">
    <div class="topbar">
        <div>
            <div class="topbar-title">Entry / Exit Records</div>
        </div>
    </div>

    <div class="page-body">
        <!-- Filters -->
        <div class="card" style="margin-bottom:20px;">
            <form method="GET" class="form-row">
                <div class="form-group">
                    <label>Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Name, Email or User ID..." value="<?= htmlspecialchars($search) ?>" style="width:200px;">
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" value="<?= $date ?>">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control">
                        <option value="all">All</option>
                        <option value="student" <?= $role=='student'?'selected':'' ?>>Student</option>
                        <option value="teacher" <?= $role=='teacher'?'selected':'' ?>>Teacher</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="all">All</option>
                        <option value="inside">Inside</option>
                        <option value="exited">Exited</option>
                    </select>   
                </div>
                <div class="form-group" style="justify-content:flex-end;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Filter</button>
                    <a href="parking_records.php" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Entry Time</th>
                            <th>Exit Time</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php if (mysqli_num_rows($result) > 0): ?>
                      <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                           <td><?= $row['id'] ?></td>
                           <td><?= htmlspecialchars($row['name']) ?></td>
                           <td><?= htmlspecialchars($row['email']) ?></td>
                           <td><?= ucfirst($row['role']) ?></td>
                           <td><?= date('d M Y, h:i A', strtotime($row['entry_time'])) ?></td>
                           <td><?= $row['exit_time'] ? date('d M Y, h:i A', strtotime($row['exit_time'])) : '—' ?></td>
                           <td><?= formatDuration($row['entry_time'], $row['exit_time']) ?></td>
                           <td><?= $row['exit_time'] ? '✅ Exited' : '🟢 Inside' ?></td>
                        </tr>
                      <?php endwhile; ?>
                     <?php else: ?>
                      <tr>
                        <td colspan="8" style="text-align:center;">No records found</td>
                      </tr>
                     <?php endif; ?>
                    </tbody>
            </div>
        </div>
 </div>
</body>
</html>
