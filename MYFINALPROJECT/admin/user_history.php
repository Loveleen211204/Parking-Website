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

$user   = null;
$history = null;
$search  = '';

if (isset($_GET['user_id'])) {
    $uid    = (int)$_GET['user_id'];
    $user   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$uid"));
    $history = mysqli_query($conn, "SELECT * FROM parking_history WHERE user_id=$uid ORDER BY entry_time DESC");
} elseif (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, trim($_GET['search']));
    $user   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE email='$search' OR name LIKE '%$search%' OR id='$search' LIMIT 1"));
    if ($user) {
        $uid     = $user['id'];
        $history = mysqli_query($conn, "SELECT * FROM parking_history WHERE user_id=$uid ORDER BY exit_time DESC");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User History – ParkAdmin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
 <?php include 'includes/sidebar.php'; ?>
  <div class="main-content">
    <div class="topbar">
        <div>
            <div class="topbar-title">User History</div>
            <div class="topbar-sub">Search for a user to see their full parking history</div>
        </div>
        <div>
            <a href="?export=1&user_id=<?= $user['id'] ?>&search=<?= urlencode($search) ?>"class="btn btn-success">
               <i class="fas fa-download"></i> Export Excel Sheet
            </a>
        </div>
    </div>

    <div class="page-body">
        <!-- Search Box -->
        <div class="card" style="margin-bottom:20px;">
            <div class="card-title"><i class="fas fa-search" style="color:var(--primary)"></i> Search User</div>
            <form method="GET" class="form-row">
                <div class="form-group" style="flex:1;">
                    <label>Enter Name, Email, or User ID</label>
                    <input type="text" name="search" class="form-control" placeholder="e.g., aman@student.com or Aman or 5" value="<?= htmlspecialchars($search) ?>" style="width:100%;">
                </div>
                <div class="form-group" style="justify-content:flex-end;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                    <a href="user_history.php" class="btn btn-secondary">Clear</a>
                </div>
            </form>
        </div>

        <?php if (isset($_GET['search']) && !$user): ?>
            <div class="alert alert-info"><i class="fas fa-info-circle"></i> No user found matching "<?= htmlspecialchars($search) ?>".</div>
        <?php endif; ?>

        <?php if ($user): ?>
            <!-- User Info Card -->
            <div class="card" style="margin-bottom:20px; display:flex; align-items:center; gap:20px;">
                <div style="width:56px; height:56px; background:rgba(79,110,247,0.12); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:22px; color:var(--primary); flex-shrink:0;">
                    <i class="fas fa-user"></i>
                </div>
                <div style="flex:1;">
                    <div style="font-size:18px; font-weight:700;"><?= htmlspecialchars($user['name']) ?></div>
                    <div style="color:var(--text-muted); font-size:14px;"><?= htmlspecialchars($user['email']) ?></div>
                </div>
                <span class="badge badge-<?= $user['role'] ?>"><?= ucfirst($user['role']) ?></span>
                <td>
                   <?php if ($user['deleted_at']): ?>
                     <span class="badge" style="background:#ef4444;">❌ Deleted</span>
                   <?php else: ?>
                    <span class="badge" style="background:#22c55e;">🟢 Active</span>
                   <?php endif; ?>
                </td>
            </div>

            <!-- History Table -->
            <?php $count = mysqli_num_rows($history); ?>
             <div class="card">
                <div class="card-title">
                    <i class="fas fa-history" style="color:var(--primary)"></i>
                     Parking History
                    <span style="margin-left:8px; font-size:13px; color:var(--text-muted); font-weight:400;"><?= $count ?> total visits</span>
                </div>
                <?php if ($count == 0): ?>
                    <p style="color:var(--text-muted); text-align:center; padding:30px;">No parking records found for this user.</p>
                <?php else: ?>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Entry Time</th>
                                <th>Exit Time</th>
                                <th>Duration</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                         <?php $i=1; while ($row = mysqli_fetch_assoc($history)): ?>
                            <tr>
                                <td style="color:var(--text-muted);"><?= $i++ ?></td>
                                <td><?= date('d M Y', strtotime($row['entry_time'])) ?></td>
                                <td><?= date('h:i A', strtotime($row['entry_time'])) ?></td>
                                <td><?= $row['exit_time'] ? date('h:i A', strtotime($row['exit_time'])) : '—' ?></td>
                                <td style="color:var(--text-muted);"><?= formatDuration($row['entry_time'], $row['exit_time']) ?></td>
                                <td>
                                  <span class="badge badge-<?= $row['exit_time'] ? 'exited' : 'inside' ?>"><?= $row['exit_time'] ? '✅ Exited' : '🟢 Inside' ?></span>
                                </td> 
                            </tr>
                         <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
             </div>
            <?php endif; ?>
    </div>
  </div>
</body>
</html>