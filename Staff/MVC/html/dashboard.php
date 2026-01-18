<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include '../../../Student/MVC/db/db_conn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: '../../../Student/MVC/html/login.php'");
    exit();
}

$page = isset($_GET['page']) ? $_GET['page'] : 'overview';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Portal | UniFind</title>
    <link rel="stylesheet" href="/UniFind/Student/MVC/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --uni-primary: #002746;   
            --uni-accent: #0056b3;   
            --uni-light: #f4f6f9;    
        }

        body { background-color: var(--uni-light); }
        
        .sidebar { background-color: var(--uni-primary); color: white; }
        .nav-links a { color: #bdc3c7; border-left: 4px solid transparent; transition: 0.3s; }
        .nav-links a:hover, .nav-links a.active { 
            background-color: rgba(255,255,255,0.1); 
            color: white; 
            border-left: 4px solid #3498db; 
        }
        
        .card-box { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .section-header { color: var(--uni-primary); margin-bottom: 20px; font-weight: 700; border-bottom: 2px solid #eee; padding-bottom: 10px; }
    </style>
</head>
<body>

    <div class="dashboard-layout">
        
        <aside class="sidebar">
            <div class="brand-box" style="padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                <h2 style="margin: 0; color: white;">UniFind <span style="font-size:0.8rem; background:#27ae60; padding:2px 6px; border-radius:4px;">STAFF</span></h2>
            </div>

            <ul class="nav-links">
                <li>
                    <a href="dashboard.php?page=overview" class="<?php echo $page == 'overview' ? 'active' : ''; ?>">
                        <i class="fas fa-chart-pie"></i> Insights & Reports
                    </a>
                </li>
                
                <li>
                    <a href="dashboard.php?page=custody" class="<?php echo $page == 'custody' ? 'active' : ''; ?>">
                        <i class="fas fa-boxes"></i> Custody Log
                    </a>
                </li>
                
                <li>
                    <a href="dashboard.php?page=fraud" class="<?php echo $page == 'fraud' ? 'active' : ''; ?>">
                        <i class="fas fa-shield-alt"></i> Fraud Control
                    </a>
                </li>
            </ul>

            <div class="sidebar-footer" style="padding: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="../../../Student/MVC/php/logout.php" class="btn-primary" style="text-align: center; display: block; background: #51b4f1; border:none;">Logout</a>
            </div>
        </aside>

        <div class="main-content">
            
            <header class="top-header">
                <div class="header-title">
                    <h1 style="color: var(--uni-primary);">
                        <?php 
                            if($page == 'overview') echo "Campus Security Insights";
                            elseif($page == 'custody') echo "Digital Custody Log";
                            elseif($page == 'fraud') echo "Fraud Control Center";
                            else echo "Staff Dashboard";
                        ?>
                    </h1>
                </div>
                <div class="user-profile">
                    <span class="name" style="color: var(--uni-primary); font-weight:bold;">
                        <?php echo htmlspecialchars($_SESSION['full_name'] ?? 'Staff Member'); ?>
                    </span>
                    <div class="profile-icon" style="background: #27ae60;">S</div>
                </div>
            </header>

            <div class="content-padding">
                <?php 
                // ROUTER
                if ($page == 'overview') {
                    include 'view_overview.php';
                } elseif ($page == 'custody') {
                    include 'view_custody.php';
                } 
                elseif ($page == 'generate_qr') {
                    include 'view_qr.php';

                }
                elseif ($page == 'fraud') {
                    include 'view_fraud.php';
                } else {
                    echo "<h2>Page Not Found</h2>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>