<?php
session_start();

// PREVENT BROWSER CACHING
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include '../../../Student/MVC/db/db_conn.php';

// 1. Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: '../../../Student/MVC/html/login.php'");
    exit();
}

// 2. ROUTING LOGIC
$page = isset($_GET['page']) ? $_GET['page'] : 'overview';

// 3. FETCH STATS (Only fetch if we are on the Overview page to save performance)
if ($page == 'overview') {
    $total_users = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='student'")->fetch_assoc()['count'];
    $total_lost = $conn->query("SELECT COUNT(*) as count FROM items WHERE status='lost'")->fetch_assoc()['count'];
    $total_found = $conn->query("SELECT COUNT(*) as count FROM items WHERE status='found'")->fetch_assoc()['count'];
    $total_claimed = $conn->query("SELECT COUNT(*) as count FROM items WHERE status='claimed'")->fetch_assoc()['count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | UniFind</title>
    <link rel="stylesheet" href="/UniFind/Student/MVC/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar { background-color: #2c3e50; color: white; }
        .brand-box { border-bottom: 1px solid #34495e; }
        .brand-box h2 { color: white; }
        .nav-links a { color: #bdc3c7; }
        .nav-links a:hover, .nav-links a.active { background-color: #34495e; color: white; }
        .sidebar-footer { border-top: 1px solid #34495e; }
        
        /* Stats Grid Style */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
    </style>
</head>
<body>

    <div class="dashboard-layout">
        
        <aside class="sidebar">
            <div class="brand-box">
                <h2 style="margin-left: 10px;">UniFind <span style="font-size:0.8rem; background:#e74c3c; padding:2px 6px; border-radius:4px;">ADMIN</span></h2>
            </div>

            <ul class="nav-links">
                <li>
                    <a href="dashboard.php?page=overview" class="<?php echo $page == 'overview' ? 'active' : ''; ?>">
                        <i class="fas fa-chart-line"></i> Overview
                    </a>
                </li>
                <li>
                    <a href="dashboard.php?page=users" class="<?php echo $page == 'users' ? 'active' : ''; ?>">
                        <i class="fas fa-users"></i> Manage Users
                    </a>
                </li>
                <li>
                    <a href="dashboard.php?page=posts" class="<?php echo $page == 'posts' ? 'active' : ''; ?>">
                        <i class="fas fa-layer-group"></i> All Posts
                    </a>
                </li>
                <li>
                    <a href="dashboard.php?page=logs" class="<?php echo $page == 'logs' ? 'active' : ''; ?>">
                        <i class="fas fa-history"></i> Activity Logs
                    </a>
                </li>
                <li><a href="#"><i class="fas fa-shield-alt"></i> Reports</a></li>
                <li><a href="#"><i class="fas fa-cogs"></i> Settings</a></li>
            </ul>

            <div class="sidebar-footer">
                <a href="../../../Student/MVC/php/logout.php" class="btn-primary" style="text-align: center; display: block; background: #c0392b; border:none; text-decoration: none;">Logout</a>
            </div>
        </aside>

        <div class="main-content">
            
            <header class="top-header">
                <div class="header-title">
                    <h1>
                        <?php 
                            if($page == 'overview') echo "Admin Overview";
                            elseif($page == 'users') echo "Manage Users";
                            elseif($page == 'posts') echo "All Posts";
                            elseif($page == 'logs') echo "Activity Logs";
                            else echo "Dashboard";
                        ?>
                    </h1>
                </div>
                <div class="user-profile">
                    <span class="name">Administrator</span>
                    <div class="profile-icon" style="background: #2c3e50;">A</div>
                </div>
            </header>

            <div class="content-padding">
                
                <?php 
                // --- CONTENT SWITCHER ---
                
                if ($page == 'overview') {
                    // --- OVERVIEW CONTENT (STATS) ---
                ?>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: #e3f2fd; color: #1565c0;"><i class="fas fa-users"></i></div>
                            <div><h3><?php echo $total_users; ?></h3><p>Total Students</p></div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon" style="background: #ffebee; color: #c62828;"><i class="fas fa-search"></i></div>
                            <div><h3><?php echo $total_lost; ?></h3><p>Active Lost</p></div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon" style="background: #e8f5e9; color: #2e7d32;"><i class="fas fa-hand-holding"></i></div>
                            <div><h3><?php echo $total_found; ?></h3><p>Active Found</p></div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon" style="background: #f3e5f5; color: #7b1fa2;"><i class="fas fa-check-double"></i></div>
                            <div><h3><?php echo $total_claimed; ?></h3><p>Solved Cases</p></div>
                        </div>
                    </div>

                    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                        <h3 style="color: #2c3e50; margin-bottom: 20px;">System Health</h3>
                        <p>System is running smoothly. Database connection active.</p>
                    </div>
                <?php
                // --- END OVERVIEW CONTENT ---

                } elseif ($page == 'users') {
                    include 'view_users.php';

                } elseif ($page == 'posts') {
                    include 'view_all_posts.php';
                
                } elseif ($page == 'logs') {
                    include 'view_logs.php';
                
                } else {
                    echo "<h2>Page not found</h2>";
                }
                ?>

            </div>
        </div>
    </div>

</body>
</html>