<?php
require_once 'config.php';
requireLogin();

// CSV Export
if (isset($_GET['export'])) {
    $date   = isset($_GET['date'])   ? mysqli_real_escape_string($conn, $_GET['date'])   : '';
    $role   = isset($_GET['role'])   ? mysqli_real_escape_string($conn, $_GET['role'])   : '';
    $status = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
    $where = "WHERE 1=1";
    if ($date)   $where .= " AND DATE(ph.entry_time)='$date'";
    if ($role && $role !== 'all') $where .= " AND u.role='$role'";
    if ($status == 'inside') $where .= " AND ph.exit_time IS NULL";
      elseif ($status == 'exited') 
      $where .= " AND ph.exit_time IS NOT NULL";
    if ($search) $where .= " AND (u.name LIKE '%$search%' OR u.email LIKE '%$search%')";
    if ($user_id) $where .= " AND ph.user_id = $user_id";
    $result = mysqli_query($conn, "SELECT ph.*, u.name, u.email, u.role FROM parking_history ph JOIN users u ON ph.user_id=u.id $where ORDER BY ph.entry_time DESC");
    $total = mysqli_num_rows($result);

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="parking_records_' . date('Y-m-d') . '.csv"');
    echo "ID,Name,Email,Role,Entry Time,Exit Time,Date,Status,Duration\n";
    while ($row = mysqli_fetch_assoc($result)) {
        $duration = formatDuration($row['entry_time'], $row['exit_time']);
        $exit     = $row['exit_time'] ?: '';
        $date_col = date('Y-m-d', strtotime($row['entry_time']));
        $status_text = $row['exit_time'] ? 'Exited' : 'Inside';
        echo "{$row['id']},\"{$row['name']}\",\"{$row['email']}\",\"{$row['role']}\",\"{$row['entry_time']}\",\"{$exit}\",\"{$date_col}\",\"" . ($row['exit_time'] ? 'Exited' : 'Inside') . "\",\"{$duration}\"\n";
    }
    exit();
}

$date = isset($_GET['date']) ? mysqli_real_escape_string($conn, $_GET['date']) : date('Y-m-d');
$total_entries    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_history WHERE DATE(entry_time)='$date'"))['c'];
$total_exits      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_history WHERE DATE(exit_time)='$date'"))['c'];
$currently_inside = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_history WHERE exit_time IS NULL"))['c'];
$student_entries  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_history ph JOIN users u ON ph.user_id=u.id WHERE DATE(ph.entry_time)='$date' AND u.role='student'"))['c'];
$teacher_entries  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_history ph JOIN users u ON ph.user_id=u.id WHERE DATE(ph.entry_time)='$date' AND u.role='teacher'"))['c'];

$daily_records = mysqli_query($conn, "
    SELECT u.name, u.email, u.role, p.entry_time, p.exit_time
    FROM parking_history p
    JOIN users u ON p.user_id = u.id
    WHERE DATE(p.entry_time) = '$date'
    ORDER BY p.entry_time DESC
"); 
// Hourly breakdown
$hourly = [];
for ($h = 6; $h <= 20; $h++) {
    $hour_str = str_pad($h, 2, '0', STR_PAD_LEFT);
    $entries  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_history WHERE DATE(entry_time)='$date' AND HOUR(entry_time)=$h"))['c'];
    $hourly[] = ['hour' => "{$hour_str}:00", 'entries' => (int)$entries];
}
$max_hourly = max(array_merge([1], array_column($hourly, 'entries')));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Report – ParkAdmin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
 <?php include 'includes/sidebar.php'; ?>

 <div class="main-content">
    <div class="topbar">
        <div>
            <div class="topbar-title">Daily Report</div>
            <div class="topbar-sub">Parking summary for <?= date('l, d F Y', strtotime($date)) ?></div>
        </div>
        <div class="topbar-right">
           <a href="?export=1&date=<?= $date ?>" class="btn btn-success">
                 <i class="fas fa-download"></i> Export Excel Sheet
           </a>
        </div>
    </div>

    <div class="page-body">
        <!-- Date Picker -->
        <div class="card" style="margin-bottom:20px;">
            <form method="GET" style="display:flex; align-items:flex-end; gap:12px;">
                <div class="form-group">
                    <label>Select Date</label>
                    <input type="date" name="date" class="form-control" value="<?= $date ?>">
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-calendar"></i> View Report</button>
            </form>
        </div>

        <!-- Metrics -->
        <div class="report-grid">
            <div class="report-metric">
                <div class="report-metric-value" style="color:var(--primary);"><?= $total_entries ?></div>
                <div class="report-metric-label">Total Entries</div>
            </div>
            <div class="report-metric">
                <div class="report-metric-value" style="color:var(--danger);"><?= $total_exits ?></div>
                <div class="report-metric-label">Total Exits</div>
            </div>
            <div class="report-metric">
                <div class="report-metric-value" style="color:var(--success);"><?= $currently_inside ?></div>
                <div class="report-metric-label">Currently Inside</div>
            </div>
            <div class="report-metric">
                <div class="report-metric-value" style="color:#a855f7;"><?= $student_entries ?></div>
                <div class="report-metric-label">Student Entries</div>
            </div>
            <div class="report-metric">
                <div class="report-metric-value" style="color:var(--warning);"><?= $teacher_entries ?></div>
                <div class="report-metric-label">Teacher Entries</div>
            </div>
        </div>

        <!---Recent Entries--->
        <div class="card">
            <div class="card-title"> Recent Entries
                <a href="parking_records.php" class="btn btn-secondary btn-sm" style="margin-left:auto;">View All</a>
            </div>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Entry Time</th>
                            <th>Exit Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(mysqli_num_rows($daily_records) > 0): ?>
                     <?php $i = 1; while($row = mysqli_fetch_assoc($daily_records)): ?>
                       <tr>
                           <td><?= $i++ ?></td>
                           <td><?= htmlspecialchars($row['name']) ?></td>
                           <td><?= htmlspecialchars($row['email']) ?></td>
                           <td><?= date('d M Y, h:i A', strtotime($row['entry_time'])) ?></td>
                           <td><?= $row['exit_time'] ? date('d M Y, h:i A', strtotime($row['exit_time'])) : '<span style="color:red;">Not Exited</span>' ?></td>
                           <td><?php if($row['exit_time']): ?><span style="color:green;">Completed</span><?php else: ?><span style="color:orange;">Inside Parking</span><?php endif; ?></td>
                        </tr>
                     <?php endwhile; ?>
                     <?php else: ?>
                     <tr><td colspan="6" style="text-align:center;">No records found</td></tr>
                    <?php endif; ?>
                    </tbody>
            </div>
 </div>
</body>
</html>
