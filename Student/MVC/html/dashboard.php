<?php
session_start();
include '../db/db_conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

function getInitials($name) {
    $words = explode(" ", $name);
    $initials = "";
    foreach ($words as $w) {
        $initials .= $w[0];
    }
    return strtoupper(substr($initials, 0, 2));
}

$page = isset($_GET['page']) ? $_GET['page'] : 'feed';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | UniFind</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .activity-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .activity-table th, .activity-table td { padding: 15px; text-align: left; border-bottom: 1px solid #f0f0f0; }
        .activity-table th { background-color: #f8f9fa; font-weight: 600; color: #555; }
        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; }
        .status-lost { background: #ffebee; color: #c62828; }
        .status-found { background: #e8f5e9; color: #2e7d32; }
        
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        @media (max-width: 1000px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    </style>
</head>
<body>

    <div class="dashboard-layout">
        
        <aside class="sidebar">
            <div class="brand-box">
                <img src="../images/American_International_University-Bangladesh_Monogram.svg.png" alt="Logo">
                <h2>UniFind</h2>
            </div>

            <ul class="nav-links">
                <li>
                    <a href="dashboard.php?page=feed" class="<?php echo ($page == 'feed') ? 'active' : ''; ?>">
                        <i class="fas fa-stream"></i> Feed
                    </a>
                </li>

                <li>
                    <a href="dashboard.php?page=home" class="<?php echo ($page == 'home') ? 'active' : ''; ?>">
                        <i class="fas fa-chart-pie"></i> My Dashboard
                    </a>
                </li>
                
                <li>
                    <a href="dashboard.php?page=report_lost" class="<?php echo ($page == 'report_lost') ? 'active' : ''; ?>">
                        <i class="fas fa-plus-circle"></i> Post Lost Item
                    </a>
                </li>
                 <li>
                    <a href="dashboard.php?page=report_found" class="<?php echo $page == 'report_found' ? 'active' : ''; ?>">
                      <i class="fas fa-hand-holding-heart"></i> Post Found Item
                    </a>
                </li>
                
                </ul>

            <div class="sidebar-footer">
                <a href="../php/logout.php" class="btn-primary" style="text-align: center; display: block; text-decoration: none;">Logout</a>
            </div>
        </aside>

        <div class="main-content">
            
            <header class="top-header">
                <div class="header-title">
                    <h1>
                        <?php 
                            if($page == 'home') echo "Dashboard";
                            elseif($page == 'report_lost') echo "Report a Lost Item";
                            elseif($page == 'feed') echo "Feed";
                            elseif($page == 'report_found') echo "Report a Found Item";
                        ?>
                    </h1>
                </div>
                
                <div class="user-profile">
                    <div class="user-info">
                        <span class="name"><?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
                        <span class="role">Student ID: <?php echo htmlspecialchars($_SESSION['student_id']); ?></span>
                    </div>
                    <div class="profile-icon">
                        <?php echo getInitials($_SESSION['full_name']); ?>
                    </div>
                </div>
            </header>

           <div class="content-padding">
                
                <?php 
 
                
                if ($page == 'home') {
   
                    $my_id = $_SESSION['user_id'];
                    $sql_my_items = "SELECT * FROM items WHERE user_id = '$my_id' ORDER BY created_at DESC";
                    $my_items_result = $conn->query($sql_my_items);
                    $total_posts = $my_items_result->num_rows;
                    include 'view_home.php'; 
                
                } elseif ($page == 'feed') {
                   
                    include 'view_feed.php';

                } elseif ($page == 'report_lost') {
                    include 'view_report_lost.php'; 
                
                } 
                elseif ($page == 'report_found') { 
                    include 'view_report_found.php';
                }
                elseif ($page == 'claim') { 
                    include 'view_claim.php';
                
                }
                elseif ($page == 'contact_owner') { 
                    include 'view_contact_owner.php';
                
                }
                else {
                    echo "<h2>Page not found</h2>";
                }
                ?>

            </div>
        </div>
    </div>

</body>
</html>