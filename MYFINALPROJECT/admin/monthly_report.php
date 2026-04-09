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

$month = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('m');
$year  = isset($_GET['year'])  ? (int)$_GET['year']  : (int)date('Y');
$month_str = str_pad($month, 2, '0', STR_PAD_LEFT);

// Default month range
$start_date = "$year-$month_str-01";
$end_date   = "$year-$month_str-" . date('t', strtotime($start_date));

// Custom range (override ONLY if both exist)
$from_date = $_GET['from_date'] ?? '';
$to_date   = $_GET['to_date'] ?? '';
if (!empty($from_date) && !empty($to_date)) {
    $start_date = $from_date;
    $end_date   = $to_date;
}
$days_in_month = date('t', strtotime($start_date));
$total_entries = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_history WHERE DATE(entry_time) BETWEEN '$start_date' AND '$end_date'"))['c'];
$total_exits   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_history WHERE DATE(exit_time) BETWEEN '$start_date' AND '$end_date'"))['c'];
$records = mysqli_query($conn, "
    SELECT u.name, u.email, p.entry_time, p.exit_time
    FROM parking_history p
    JOIN users u ON p.user_id = u.id
    WHERE DATE(p.entry_time) BETWEEN '$start_date' AND '$end_date'
    ORDER BY p.entry_time DESC
");

// Daily data for chart
$daily_labels = $daily_entries = [];
$peak_day = ''; $peak_count = 0;
for ($d = 1; $d <= $days_in_month; $d++) {
    $day_str = "$year-$month_str-" . str_pad($d, 2, '0', STR_PAD_LEFT);
    $c = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_history WHERE DATE(entry_time)='$day_str'"))['c'];
    $daily_labels[]  = $d;
    $daily_entries[] = (int)$c;
    if ($c > $peak_count) { $peak_count = $c; $peak_day = $day_str; }
}
$avg = count(array_filter($daily_entries)) > 0 ? round(array_sum($daily_entries) / count($daily_entries), 1) : 0;
$max_val = max(array_merge([1], $daily_entries));
$months_list = ['January','February','March','April','May','June','July','August','September','October','November','December'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monthly Report – ParkAdmin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
 <?php include 'includes/sidebar.php'; ?>
  <div class="main-content">
    <div class="topbar">
        <div>
            <div class="topbar-title">Monthly Report</div>
            <div class="topbar-sub"><?= $months_list[$month-1] ?> <?= $year ?></div>
        </div>
        <div class="topbar-right">
            <a href="?export=1&from_date=<?= $start_date ?>&to_date=<?= $end_date ?>" class="btn btn-success">
                <i class="fas fa-download"></i> Export Excel Sheet
            </a>
        </div>
    </div>

    <div class="page-body">
        <!-- Month Picker -->
        <div class="card" style="margin-bottom:20px;">
            <form method="GET" class="form-row">
                <div class="form-group">
                    <label>From Date</label>
                    <input type="date" name="from_date" class="form-control" value="<?= $_GET['from_date'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label>To Date</label>
                    <input type="date" name="to_date" class="form-control" value="<?= $_GET['to_date'] ?? '' ?>">
                </div>
                <div class="form-group">
                    <label>Month</label>
                    <select name="month" class="form-control">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                         <option value="<?= $m ?>" <?= $m==$month?'selected':'' ?>><?= $months_list[$m-1] ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Year</label>
                    <select name="year" class="form-control">
                        <?php for ($y = date('Y'); $y >= date('Y')-3; $y--): ?>
                         <option value="<?= $y ?>" <?= $y==$year?'selected':'' ?>><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group" style="justify-content:flex-end;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-calendar"></i> View Report</button>
                </div>
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
                <div class="report-metric-value" style="color:var(--success);"><?= $avg ?></div>
                <div class="report-metric-label">Avg Daily Entries</div>
            </div>
            <div class="report-metric">
                <div class="report-metric-value" style="color:var(--warning); font-size:22px;"><?= $peak_day ? date('d M', strtotime($peak_day)) : '—' ?></div>
                <div class="report-metric-label">Per Day (<?= $peak_count ?> entries)</div>
            </div>
        </div>

        <!--- Recent Entries-->
        <div class="card">
            <div class="card-title">
                Recent Entries
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
                     <?php if(mysqli_num_rows($records) > 0): ?>
                      <?php $i = 1; while($row = mysqli_fetch_assoc($records)): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= date('d M Y, h:i A', strtotime($row['entry_time'])) ?></td>
                            <td><?= $row['exit_time'] ? date('d M Y, h:i A', strtotime($row['exit_time'])) : '<span style="color:red;">Not Exited</span>' ?></td>
                            <td>
                                <?php if($row['exit_time']): ?>
                                    <span style="color:green;">Completed</span>
                                <?php else: ?>
                                    <span style="color:orange;">Inside Parking</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                       <?php endwhile; ?>
                     <?php else: ?>
                       <tr>
                        <td colspan="6" style="text-align:center;">No records found</td>
                       </tr>
                     <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
</body>
</html>
