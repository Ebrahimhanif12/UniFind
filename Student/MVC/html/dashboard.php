<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Helper: Get Initials (e.g. "Ebrahim Hanif" -> "EH")
function getInitials($name) {
    $words = explode(" ", $name);
    $initials = "";
    foreach ($words as $w) {
        $initials .= $w[0];
    }
    return strtoupper(substr($initials, 0, 2));
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
        /* Force the grid to show 4 items in a row */
        .stats-grid {
            display: grid;
            /* This forces 4 equal columns */
            grid-template-columns: repeat(4, 1fr); 
            gap: 20px;
            margin-bottom: 30px;
        }

        /* Responsive: If screen is small, switch to 2x2 */
        @media (max-width: 1000px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
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
                <li><a href="#" class="active"><i class="fas fa-th-large"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-search"></i> Lost Items</a></li>
                <li><a href="#"><i class="fas fa-hand-holding-heart"></i> Found Items</a></li>
                <li><a href="#"><i class="fas fa-history"></i> My History</a></li>
                <li><a href="#"><i class="fas fa-user-cog"></i> Settings</a></li>
            </ul>

            <div class="sidebar-footer">
                <a href="../php/logout.php" class="btn-primary" style="text-align: center; display: block; text-decoration: none;">
                    Logout
                </a>
            </div>
        </aside>

        <div class="main-content">
            
            <header class="top-header">
                <div class="header-title">
                    <h1>Overview</h1>
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
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon icon-blue">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div>
                            <h3>0</h3>
                            <p>Active Claims</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon icon-gold">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div>
                            <h3>0</h3>
                            <p>Reported Lost</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon icon-green">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h3>0</h3>
                            <p>Items Recovered</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon icon-purple" style="background: #f3e5f5; color: #9c27b0;">
                            <i class="fas fa-medal"></i>
                        </div>
                        <div>
                            <h3><?php echo isset($_SESSION['karma_points']) ? $_SESSION['karma_points'] : 0; ?></h3>
                            <p>Karma Points</p>
                        </div>
                    </div>
                </div>

                <div style="background: white; padding: 40px; border-radius: 12px; text-align: center; color: #888;">
                    <img src="../images/American_International_University-Bangladesh_Monogram.svg.png" style="width: 80px; opacity: 0.5; margin-bottom: 20px;">
                    <h2>Welcome to AIUB UniFind</h2>
                    <p>Select an option from the sidebar to start reporting lost or found items.</p>
                </div>

            </div>
        </div>
    </div>

</body>
</html>