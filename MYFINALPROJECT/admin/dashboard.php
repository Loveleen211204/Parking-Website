<?php
require_once 'config.php';
requireLogin();

$today = date('Y-m-d');

// Stats
$total_users     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users"))['c'];
$total_students  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users WHERE role='student'"))['c'];
$total_teachers  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM users WHERE role='teacher'"))['c'];
$today_entries   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_history WHERE DATE(entry_time)='$today'"))['c'];
$today_exits     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_history WHERE DATE(exit_time)='$today'"))['c'];
$inside_count = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS c FROM parking_history WHERE exit_time IS NULL"))['c'];

// Recent entries
$recent_result = mysqli_query($conn, "
    SELECT ph.*, u.name, u.email, u.role 
    FROM parking_history ph 
    JOIN users u ON ph.user_id = u.id 
    ORDER BY ph.entry_time DESC 
    LIMIT 10
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – ParkAdmin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
 <?php include 'includes/sidebar.php'; ?>

 <div class="main-content">
    <div class="topbar">
        <div>
            <div class="topbar-title">Dashboard</div>
            <div class="topbar-sub">Welcome back, <?= htmlspecialchars($_SESSION['admin_name']) ?>! — <?= date('l, d M Y') ?></div>
        </div>
    </div>

    <div class="page-body">
        <!-- Stats Grid -->
        <div class="stats-grid">
            <a href="../view_allusers.php" style="text-decoration:none;">
             <div class="stat-card">
               <div class="stat-icon blue"><i class="fas fa-users"></i></div>
                 <div>
                   <div class="stat-value"><?= $total_users ?></div>
                   <div class="stat-label">Total Users</div>
                 </div>
               </div>
            </a>

            <a href="../view_studentusers.php" style="text-decoration:none;">
             <div class="stat-card">
               <div class="stat-icon purple"><i class="fas fa-user-graduate"></i></div>
                 <div>
                   <div class="stat-value"><?= $total_students ?></div>
                   <div class="stat-label">Students</div>
                 </div>
               </div>
            </a>

            <a href="../view_teacherusers.php" style="text-decoration:none;">
             <div class="stat-card">
               <div class="stat-icon orange"><i class="fas fa-chalkboard-teacher"></i></div>
                 <div>
                   <div class="stat-value"><?= $total_teachers ?></div>
                   <div class="stat-label">Teachers</div>
                 </div>
               </div>
            </a>

            <a href="../view_contacts.php" style="text-decoration:none;">
             <div class="stat-card">
               <div><i class="fas fa-question-circle"></i></div>
                 <div>    
                   <div class="stat-label"> Help Requests </div>
                 </div>
               </div>
            </a>
           <br>

          <div class="stat-card no-hover">
            <div class="stat-icon blue"><i class="fas fa-sign-in-alt"></i></div>
                <div>
                  <div class="stat-value"><?= $today_entries ?></div>
                  <div class="stat-label">Today's Entries</div>
                </div>
          </div>
            <div class="stat-card no-hover">
            <div class="stat-icon red"><i class="fas fa-sign-out-alt"></i></div>
                <div>
                  <div class="stat-value"><?= $today_exits ?></div>
                  <div class="stat-label">Today's Exits</div>
                </div>
              </div>
            <div class="stat-card no-hover">
            <div class="stat-icon green"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                  <div class="stat-value"><?= $inside_count ?></div>
                  <div class="stat-label">Currently Inside</div>
                 </div>
                </div>
            </div>

         <div style="display:inline-block;">
            <!-- Parking Occupancy -->
            <div class="card" style="padding:20px; border-radius:16px; width:320px;">
                <div class="card-title" style="margin-bottom:18px;"><i class="fas fa-car" style="color:var(--primary)"></i> Parking Status</div>

            <!-- Current Occupancy -->
            <div style="margin-bottom:20px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <span style="font-size:13px; color:var(--text-muted); font-weight:600;">Currently Occupied</span>
                    <span style="font-size:22px; font-weight:800; color:var(--primary);"><?= $inside_count ?></span>
                </div>

             <!-- Progress Bar -->
             <div class="occupancy-bar" style="height:10px; border-radius:10px; background:#e5e7eb;">
                <div class="occupancy-fill" 
                    style="height:100%; border-radius:10px; background:linear-gradient(90deg,#3b82f6,#6366f1);
                    width:<?= min(100, $total_users > 0 ? round(($inside_count/$total_users)*100) : 0) ?>%">
                </div>
             </div> 
             <div style="font-size:12px; color:var(--text-muted); margin-top:6px;"><?= $inside_count ?> users inside</div>
            </div>

        <!-- Divider -->
        <hr style="border:none; border-top:1px solid #eee; margin:16px 0;">

        <!-- Today Stats -->
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">

        <!-- Entries -->
        <div style="background:#eff6ff; padding:12px; border-radius:10px; text-align:center;">
            <div style="font-size:12px; color:#6b7280;">Entries</div>
            <div style="font-size:18px; font-weight:800; color:#3b82f6;"><i class="fas fa-sign-in-alt"></i> <?= $today_entries ?></div>
        </div>

        <!-- Exits -->
        <div style="background:#fef2f2; padding:12px; border-radius:10px; text-align:center;">
            <div style="font-size:12px; color:#6b7280;">Exits</div>
            <div style="font-size:18px; font-weight:800; color:#ef4444;"><i class="fas fa-sign-out-alt"></i> <?= $today_exits ?></div>
        </div>
        </div>
      </div>
        <!-- Recent Entries -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-history" style="color:var(--primary)"></i> Recent Entries
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
                      <?php while ($row = mysqli_fetch_assoc($recent_result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td>
                                <div style="font-weight:600;"><?= htmlspecialchars($row['name']) ?></div>
                                <div style="font-size:12px; color:var(--text-muted);"><?= htmlspecialchars($row['email']) ?></div>
                            </td>
                            <td><span class="badge badge-<?= $row['role'] ?>"><?= ucfirst($row['role']) ?></span></td>
                            <td><?= !empty($row['entry_time']) ? date('d M Y, h:i A', strtotime($row['entry_time'])) : '—' ?></td>
                            <td><?= !empty($row['exit_time']) ? date('d M Y, h:i A', strtotime($row['exit_time'])) : '<span style="color:var(--text-muted)">—</span>' ?></td>
                            <td><span class="badge badge-<?= $row['exit_time'] ? 'exited' : 'inside' ?>"><?= $row['exit_time'] ? '✅ Exited' : '🟢 Inside' ?></span></td>
                        </tr>
                      <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 </div>
</body>
</html>
