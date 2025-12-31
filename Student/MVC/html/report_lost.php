<?php
session_start();
// Security Check
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Helper for Initials
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
    <title>Report Lost Item | UniFind</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="dashboard-layout">
        
        <aside class="sidebar">
            <div class="brand-box">
                <img src="../images/American_International_University-Bangladesh_Monogram.svg.png" alt="Logo">
                <h2>UniFind</h2>
            </div>

            <ul class="nav-links">
                <li><a href="dashboard.php"><i class="fas fa-th-large"></i> Dashboard</a></li>
                <li><a href="report_lost.php" class="active"><i class="fas fa-search"></i> Lost Items</a></li>
                <li><a href="#"><i class="fas fa-hand-holding-heart"></i> Found Items</a></li>
                <li><a href="#"><i class="fas fa-history"></i> My History</a></li>
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
                    <h1>Report Lost Item</h1>
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
                <div style="background: white; padding: 40px; border-radius: 12px; max-width: 800px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                    
                    <h2 style="color: var(--primary-blue); margin-bottom: 20px;">Item Details</h2>

                    <form action="../php/report_lost_control.php" method="POST" enctype="multipart/form-data">
                        
                        <div class="form-group">
                            <label>What did you lose?</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Blue Water Bottle" required>
                        </div>

                        <div class="row-group" style="display: flex; gap: 20px;">
                            <div class="form-group" style="flex: 1;">
                                <label>Category</label>
                                <select name="category" class="form-control">
                                    <option value="Electronics">Electronics</option>
                                    <option value="Documents">Documents (ID/Wallet)</option>
                                    <option value="Clothing">Clothing</option>
                                    <option value="Accessories">Accessories</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="form-group" style="flex: 1;">
                                <label>Date Lost</label>
                                <input type="date" name="lost_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Location (Where did you last see it?)</label>
                            <input type="text" name="location" class="form-control" placeholder="e.g. Annex 1, Room 3102" required>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Describe color, brand, or unique marks..."></textarea>
                        </div>

                        <div class="form-group">
                            <label>Upload Image (Optional)</label>
                            <input type="file" name="item_image" class="form-control" accept="image/*">
                        </div>

                        <button type="submit" class="btn-reg" style="margin-top: 10px;">Submit Report</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</body>
</html>