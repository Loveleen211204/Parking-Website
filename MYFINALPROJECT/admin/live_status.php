<?php
require_once 'config.php';
requireLogin();
$result = mysqli_query($conn, "
    SELECT ph.*, u.name, u.email, u.role
    FROM parking_history ph
    JOIN users u ON ph.user_id = u.id
    WHERE ph.exit_time IS NULL
    ORDER BY ph.entry_time DESC
");
$inside_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_history WHERE exit_time IS NULL"))['c'];   
$count = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live Status – ParkAdmin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <meta http-equiv="refresh" content="30">
</head>
<body>
 <?php include 'includes/sidebar.php'; ?>
 <div class="main-content">
    <div class="topbar">
        <div>
            <div class="topbar-title">
                <span class="live-dot" style="margin-right:8px;"></span>Live Parking Status
            </div>
            <div class="topbar-sub"> Last updated: <?= date('h:i A') ?></div>
        </div>
        
        <div style="display:flex; gap:15px;">
        <!-- Inside -->
          <div style="background:rgba(34,197,94,0.1); border-radius:10px; padding:10px 20px; text-align:center;">
             <div style="font-size:28px; font-weight:800; color:var(--success);"><?= $inside_count ?></div>
             <div style="font-size:12px;">Inside</div>
          </div>
        </div>
    </div>

    <div class="page-body">
        <?php if ($count == 0): ?>
            <div class="card" style="text-align:center; padding:60px;">
                <div style="font-size:50px; margin-bottom:16px;">🅿️</div>
                <div style="font-size:18px; font-weight:600; color:var(--text-muted);">Campus is empty</div>
                <p style="color:var(--text-muted); margin-top:8px;">No one is currently inside the campus.</p>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-title">
                  <i class="fas fa-map-marker-alt" style="color:var(--success)"></i>
                   People Currently Inside Campus
                </div>
                <div class="table-wrapper">
                 <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Entry Time</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td style="color:var(--text-muted);"><?= $i++ ?></td>
                            <td>
                                <div style="font-weight:600;"><?= htmlspecialchars($row['name']) ?></div>
                            </td>
                            <td style="color:var(--text-muted); font-size:13px;"><?= htmlspecialchars($row['email']) ?></td>
                            <td><span class="badge badge-<?= $row['role'] ?>"><?= ucfirst($row['role']) ?></span></td>
                            <td style="font-size:13px;"><?= date('h:i A', strtotime($row['entry_time'])) ?></td>
                        </tr>
                      <?php endwhile; ?>
                    </tbody>
                 </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
 </div>
</body>
</html>
