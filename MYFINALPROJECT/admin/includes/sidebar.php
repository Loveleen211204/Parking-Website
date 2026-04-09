<?php
$current_page = basename($_SERVER['PHP_SELF']);
$admin = getCurrentAdmin($conn);
?>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="fas fa-parking"></i></div>
        <div class="brand-text">
            <span class="brand-title">ParkAdmin</span>
            <span class="brand-sub">Management Panel</span>
        </div>
    </div>


    <nav class="sidebar-nav">
        <div class="nav-section-label">MAIN</div>
        <a href="dashboard.php" class="nav-item <?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>

        <div class="nav-section-label">MANAGEMENT</div>
        <a href="users.php" class="nav-item <?= $current_page == 'users.php' ? 'active' : '' ?>">
            <i class="fas fa-users"></i>
            <span>Users</span>
        </a>
        <a href="parking_records.php" class="nav-item <?= $current_page == 'parking_records.php' ? 'active' : '' ?>">
            <i class="fas fa-clipboard-list"></i>
            <span>Entry / Exit Records</span>
        </a>

        <a href="live_status.php" class="nav-item <?= $current_page == 'live_status.php' ? 'active' : '' ?>">
            <i class="fas fa-circle text-success"></i>
            <span>Live Status</span>
            <span class="badge-live ms-auto" id="live-count">...</span>
        </a>

        <div class="nav-section-label">REPORTS</div>
        <a href="user_history.php" class="nav-item <?= $current_page == 'user_history.php' ? 'active' : '' ?>">
            <i class="fas fa-history"></i>
            <span>User History</span>
        </a>
        <a href="daily_report.php" class="nav-item <?= $current_page == 'daily_report.php' ? 'active' : '' ?>">
            <i class="fas fa-calendar-day"></i>
            <span>Daily Report</span>
        </a>
        <a href="monthly_report.php" class="nav-item <?= $current_page == 'monthly_report.php' ? 'active' : '' ?>">
            <i class="fas fa-calendar-alt"></i>
            <span>Monthly Report</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="admin-info">
            <div class="admin-avatar"><i class="fas fa-user-shield"></i></div>
            <div class="admin-details">
                <span class="admin-name"><?= htmlspecialchars($admin['name']) ?></span>
                <span class="admin-role">Administrator</span>
            </div>
        </div>
        <div class="admin-actions">
            <a href="profile.php" title="Profile"><i class="fas fa-cog"></i></a>
            <a href="logout.php" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
</div>

<script> 
// Fetch live count for sidebar badge
function updateLiveCount() {
    fetch('ajax/live_count.php')
        .then(r => r.json())
        .then(data => {
            document.getElementById('live-count').textContent = data.count;
        }).catch(() => {});
}
updateLiveCount();
setInterval(updateLiveCount, 30000);
</script>
