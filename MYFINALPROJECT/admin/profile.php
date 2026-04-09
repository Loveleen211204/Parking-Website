<?php
require_once 'config.php';
requireLogin();
$admin   = getCurrentAdmin($conn);
$success = '';
$error   = '';

// Update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $name  = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    if (empty($name) || empty($email)) {
        $error = "Name and email are required.";
    } else {
        mysqli_query($conn, "UPDATE admins SET name='$name', email='$email' WHERE id={$admin['id']}");
        $_SESSION['admin_name'] = $name;
        $success = "Profile updated successfully!";
        $admin = getCurrentAdmin($conn);
    }
}

// Change password
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current = $_POST['current_password'];
    $new     = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];
    $db_admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admins WHERE id={$admin['id']}"));
    if ($db_admin['password'] !== $current) {
        $error = "Current password is incorrect.";
    } elseif (strlen($new) < 6) {
        $error = "New password must be at least 6 characters.";
    } elseif ($new !== $confirm) {
        $error = "New passwords do not match.";
    } else {
        mysqli_query($conn, "UPDATE admins SET password='$new' WHERE id={$admin['id']}");
        $success = "Password changed successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile – ParkAdmin</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
 <?php include 'includes/sidebar.php'; ?>
  <div class="main-content">
    <div class="topbar">
        <div>
            <div class="topbar-title">Admin Profile</div>
            <div class="topbar-sub">Manage your account settings</div>
        </div>
        <div class="topbar-right">
            <a href="logout.php" class="btn btn-danger">
               <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <div class="page-body" style="max-width:700px;">
        <?php if ($success): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= $success ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> <?= $error ?></div>
        <?php endif; ?>

        <!-- Admin Info Banner -->
        <div class="card" style="margin-bottom:20px; display:flex; align-items:center; gap:20px;">
            <div style="width:72px; height:72px; background:rgba(79,110,247,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:28px; color:var(--primary); flex-shrink:0;">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <div style="font-size:20px; font-weight:700;"><?= htmlspecialchars($admin['name']) ?></div>
                <div style="color:var(--text-muted);"><?= htmlspecialchars($admin['email']) ?></div>
                <span class="badge badge-active" style="margin-top:6px;">Administrator</span>
            </div>
        </div>

        <!-- Update Profile -->
        <div class="card" style="margin-bottom:20px;">
            <div class="card-title"><i class="fas fa-edit" style="color:var(--primary)"></i> Update Profile</div>
            <form method="POST">
                <div class="form-group" style="margin-bottom:14px;">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($admin['name']) ?>" required style="max-width:400px;">
                </div>
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($admin['email']) ?>" required style="max-width:400px;">
                </div>
                <button type="submit" name="update_profile" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </form>
        </div>

        <!-- Change Password -->
        <div class="card">
            <div class="card-title"><i class="fas fa-key" style="color:var(--warning)"></i> Change Password</div>
            <form method="POST">
                <div class="form-group" style="margin-bottom:14px;">
                    <label>Current Password</label>
                    <input type="password" name="current_password" class="form-control" required style="max-width:400px;">
                </div>
                <div class="form-group" style="margin-bottom:14px;">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" required style="max-width:400px;" minlength="6">
                </div>
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" required style="max-width:400px;">
                </div>
                <button type="submit" name="change_password" class="btn btn-warning">
                    <i class="fas fa-lock"></i> Change Password
                </button>
            </form>
        </div>
    </div>
  </div>
</body>
</html>