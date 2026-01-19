<?php
session_start();

// PREVENT CACHING
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

include '../db/db_conn.php';
include '../php/check_ban_status.php'; // Gatekeeper
include '../php/system_control.php';   // Logic Engine

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

// FETCH ANNOUNCEMENT & DETERMINE COLORS
$announcement = getGlobalAnnouncement($conn);
$banner_bg = '#1784dd'; 
$banner_icon = 'fa-info-circle';

if ($announcement) {
    if ($announcement['type'] == 'warning') {
        $banner_bg = '#f39c12'; 
        $banner_icon = 'fa-exclamation-triangle';
    } elseif ($announcement['type'] == 'danger') {
        $banner_bg = '#c0392b'; 
        $banner_icon = 'fa-exclamation-circle';
    } elseif ($announcement['type'] == 'info') {
        $banner_bg = '#3498db'; 
        $banner_icon = 'fa-info-circle';
    }
}
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
        
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        @media (max-width: 1000px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }

        /* Animation for Bottom Banner */
        @keyframes slideUpFade {
            from { transform: translateY(100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body>

    <div class="dashboard-layout">
        
        <aside class="sidebar">
            <div class="brand-box">
                <img src="../images/American_International_University-Bangladesh_Monogram.svg.png" alt="Logo" style="width: 40px; height: auto; margin-right: 10px;">
                <h2>UniFind</h2>
            </div>

            <ul class="nav-links">
                <li><a href="dashboard.php?page=feed" class="<?php echo ($page == 'feed') ? 'active' : ''; ?>"><i class="fas fa-stream"></i> Feed</a></li>
                <li><a href="dashboard.php?page=home" class="<?php echo ($page == 'home') ? 'active' : ''; ?>"><i class="fas fa-chart-pie"></i> My Dashboard</a></li>
                <li><a href="dashboard.php?page=report_lost" class="<?php echo ($page == 'report_lost') ? 'active' : ''; ?>"><i class="fas fa-plus-circle"></i> Post Lost Item</a></li>
                <li><a href="dashboard.php?page=report_found" class="<?php echo $page == 'report_found' ? 'active' : ''; ?>"><i class="fas fa-hand-holding-heart"></i> Post Found Item</a></li>
            </ul>

            <div class="sidebar-footer">
                <a href="../php/logout.php" class="btn-primary" style="text-align: center; display: block; text-decoration: none;">Logout</a>
            </div>
        </aside>

        <div class="main-content" style="display: flex; flex-direction: column; height: 100vh; overflow-y: auto;">

            <header class="top-header" style="flex-shrink: 0;">
                <div class="header-title">
                    <h1>
                        <?php 
                            if($page == 'home') echo "My Dashboard";
                            elseif($page == 'report_lost') echo "Report a Lost Item";
                            elseif($page == 'feed') echo "Global Feed";
                            elseif($page == 'report_found') echo "Report a Found Item";
                            elseif($page == 'claim') echo "Claim Item";
                            else echo "Dashboard";
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

            <div class="content-padding" style="flex-grow: 1; padding-bottom: 80px;"> <?php 
                if ($page == 'home') {
                    $my_id = $_SESSION['user_id'];
                    $sql_my_items = "SELECT * FROM items WHERE user_id = '$my_id' ORDER BY created_at DESC";
                    $my_items_result = $conn->query($sql_my_items);
                    $total_posts = $my_items_result->num_rows;
                    include 'view_home.php'; 
                } elseif ($page == 'feed') { include 'view_feed.php';
                } elseif ($page == 'report_lost') { include 'view_report_lost.php'; 
                } elseif ($page == 'report_found') { include 'view_report_found.php';
                } elseif ($page == 'claim') { include 'view_claim.php';
                } elseif ($page == 'contact_owner') { include 'view_contact_owner.php';
                } else { echo "<div style='text-align:center; padding:50px; color:#888;'><h2>Page not found</h2></div>"; }
                ?>
            </div>

        </div>
    </div>

   <?php if ($announcement): ?>
        <div id="announcementBanner" style="
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: <?php echo $banner_bg; ?>;
            color: white;
            padding: 15px 50px 15px 20px; /* Added right padding for button space */
            box-shadow: 0 -4px 10px rgba(0,0,0,0.1);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            font-family: 'Segoe UI', sans-serif;
            animation: slideUpFade 0.6s ease-out;
            box-sizing: border-box; /* Ensures padding stays inside width */
        ">
            <i class="fas <?php echo $banner_icon; ?>" style="font-size: 1.2rem;"></i>
            
            <div style="font-size: 1rem;">
                <span style="font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; margin-right: 5px;">ANNOUNCEMENT:</span>
                <span style="font-weight: 400;"><?php echo htmlspecialchars($announcement['message']); ?></span>
            </div>

            <button onclick="document.getElementById('announcementBanner').style.display='none'" 
                style="
                    position: absolute;
                    right: 20px;
                    top: 50%;
                    transform: translateY(-50%);
                    background: none;
                    border: none;
                    color: white;
                    font-size: 1.5rem; /* Larger touch target */
                    line-height: 1;
                    font-weight: bold;
                    cursor: pointer;
                    opacity: 0.8;
                    transition: opacity 0.2s;
                    padding: 0 10px;
                "
                onmouseover="this.style.opacity=1"
                onmouseout="this.style.opacity=0.8"
                title="Close"
            >
                &times; </button>
        </div>
    <?php endif; ?>
    </body>
</html>