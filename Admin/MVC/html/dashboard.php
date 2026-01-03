<?php
session_start();
 
include '../../../Student/MVC/db/db_conn.php';
 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: '../../../Student/MVC/html/login.php'");
    exit();
}
 
$total_users = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='student'")->fetch_assoc()['count'];
$total_lost = $conn->query("SELECT COUNT(*) as count FROM items WHERE status='lost'")->fetch_assoc()['count'];
$total_found = $conn->query("SELECT COUNT(*) as count FROM items WHERE status='found'")->fetch_assoc()['count'];
$total_claimed = $conn->query("SELECT COUNT(*) as count FROM items WHERE status='claimed'")->fetch_assoc()['count'];
 
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
                <li><a href="#" class="active"><i class="fas fa-chart-line"></i> Overview</a></li>
                <li><a href="#"><i class="fas fa-users"></i> Manage Users</a></li>
                <li><a href="#"><i class="fas fa-layer-group"></i> All Posts</a></li>
                <li><a href="#"><i class="fas fa-shield-alt"></i> Reports</a></li>
                <li><a href="#"><i class="fas fa-cogs"></i> Settings</a></li>
            </ul>
 
            <div class="sidebar-footer">
                <a href="../../../Student/MVC/php/logout.php" class="btn-primary" style="text-align: center; display: block; background: #c0392b; border:none;">Logout</a>
            </div>
        </aside>
 
        <div class="main-content">
           
            <header class="top-header">
                <div class="header-title">
                    <h1>Admin Overview</h1>
                </div>
                <div class="user-profile">
                    <span class="name">Administrator</span>
                    <div class="profile-icon" style="background: #2c3e50;">A</div>
                </div>
            </header>
 
            <div class="content-padding">
               
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
 
            </div>
        </div>
    </div>
 
</body>
</html>