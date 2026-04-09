<?php
require_once 'config.php';
requireLogin();

// ✅ Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "UPDATE users SET deleted_at = NOW() WHERE id = $id");
    header("Location: users.php?msg=deleted");
    exit();
}

// ✅ Filters
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, trim($_GET['search'])) : '';
$role   = isset($_GET['role']) ? mysqli_real_escape_string($conn, $_GET['role']) : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';
$where = "WHERE 1=1";

if ($status == 'active') {
    $where .= " AND u.deleted_at IS NULL";
} elseif ($status == 'deleted') {
    $where .= " AND u.deleted_at IS NOT NULL";
}

if ($role && $role !== 'all') {
    $where .= " AND u.role='$role'";
}

if ($search) {
    if (is_numeric($search)) {
        $where .= " AND u.id = $search";
    } else {
        $where .= " AND (u.name LIKE '%$search%' OR u.email LIKE '%$search%')";
    }
}

$result = mysqli_query($conn, "SELECT u.* FROM users u $where ORDER BY u.id DESC");
$total = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management – ParkAdmin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .table-wrapper {
            max-height: 500px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
 <?php include 'includes/sidebar.php'; ?>
    <div class="main-content">
        <div class="topbar">
          <div>
            <div class="topbar-title">User Management</div>
            <div class="topbar-sub">View, search and delete users</div>
          </div>
          <div class="topbar-right">
            <span style="font-size:13px; color:var(--text-muted);"><?= $total ?> users found</span>
          </div>
        </div>

        <div class="page-body"> 
          <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                User deleted successfully.
            </div>
          <?php endif; ?>

          <!-- Filters -->
          <div class="card" style="margin-bottom:20px;">
            <form method="GET" class="form-row">
                <div class="form-group">
                    <label>Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Name, Email or User ID..." value="<?= htmlspecialchars($search) ?>" style="width:220px;">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control">
                        <option value="all" <?= $role=='all'||!$role?'selected':'' ?>>All Roles</option>
                        <option value="student" <?= $role=='student'?'selected':'' ?>>Student</option>
                        <option value="teacher" <?= $role=='teacher'?'selected':'' ?>>Teacher</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="all">All</option>
                        <option value="active" <?= $status=='active'?'selected':'' ?>>Active</option>
                        <option value="deleted" <?= $status=='deleted'?'selected':'' ?>>Deleted</option>
                    </select>
                </div>
                <div class="form-group" style="justify-content:flex-end;">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                    <a href="users.php" class="btn btn-secondary">Reset</a>
                </div>
            </form>
          </div>

          <!-- Table -->
          <div class="card">
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php while ($user = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td style="color:var(--text-muted); font-size:13px;">#<?= $user['id'] ?></td>
                            <td style="font-weight:600;"><?= htmlspecialchars($user['name']) ?></td>
                            <td style="color:var(--text-muted);"><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span class="badge badge-<?= $user['role'] ?>">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($user['deleted_at']): ?>
                                 <span class="badge" style="background:#ef4444;">❌ Deleted</span>
                                <?php else: ?>
                                 <span class="badge" style="background:#22c55e;">🟢 Active</span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size:13px; color:var(--text-muted);">
                                <?= isset($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : '—' ?>
                            </td>
                            <td>
                                <div style="display:flex; gap:6px;">
                                    <a href="user_history.php?user_id=<?= $user['id'] ?>" class="btn btn-secondary btn-sm" title="View History">
                                        <i class="fas fa-history"></i>
                                    </a>
                                    <!-- ✅ ONLY DELETE BUTTON LEFT -->
                                    <a href="users.php?delete=<?= $user['id'] ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Delete this user? This cannot be undone.')">
                                       <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                     <?php endwhile; ?>
                     <?php if ($total == 0): ?>
                        <tr>
                            <td colspan="7" style="text-align:center; padding:30px; color:var(--text-muted);">No users found.</td>
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