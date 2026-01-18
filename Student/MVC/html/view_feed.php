<?php

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Fetching items and user info
$sql = "SELECT items.*, users.full_name, users.student_id 
        FROM items 
        JOIN users ON items.user_id = users.user_id 
        WHERE (title LIKE '%$search%' OR description LIKE '%$search%' OR location LIKE '%$search%') ";

// Filtering Logic
if ($filter == 'lost') {
    $sql .= " AND status = 'lost'";
} elseif ($filter == 'found') {
    $sql .= " AND status IN ('found', 'custody')"; // 'found' filter shows custody items too
} elseif ($filter == 'custody') {
    $sql .= " AND status = 'custody'";
} else {
    // Show ALL active items (Lost, Found, AND Custody)
    $sql .= " AND status IN ('lost', 'found', 'custody')";
}

$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<div style="width: 100%;">

    <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); display: flex; gap: 15px; flex-wrap: wrap; align-items: center;">
        
        <form action="dashboard.php" method="GET" style="flex-grow: 1; display: flex; gap: 10px;">
            <input type="hidden" name="page" value="feed"> 
            <div style="position: relative; flex-grow: 1;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 12px; color: #999;"></i>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search for 'Wallet', 'Annex 1', 'Canon Camera'..." 
                       style="width: 100%; padding: 10px 10px 10px 40px; border: 1px solid #ddd; border-radius: 8px; outline: none; box-sizing: border-box;">
            </div>
            <button type="submit" class="btn-primary" style="padding: 0 25px;">Search</button>
        </form>

        <div style="display: flex; gap: 10px;">
            <a href="dashboard.php?page=feed&filter=all" 
               style="text-decoration: none; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 500; 
               <?php echo $filter == 'all' ? 'background: #2c3e50; color: white;' : 'background: #eee; color: #555;'; ?>">
               All
            </a>
            <a href="dashboard.php?page=feed&filter=lost" 
               style="text-decoration: none; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 500; 
               <?php echo $filter == 'lost' ? 'background: #e74c3c; color: white;' : 'background: #ffebee; color: #c62828;'; ?>">
               Lost
            </a>
            <a href="dashboard.php?page=feed&filter=found" 
               style="text-decoration: none; padding: 8px 16px; border-radius: 20px; font-size: 0.9rem; font-weight: 500; 
               <?php echo $filter == 'found' ? 'background: #27ae60; color: white;' : 'background: #e8f5e9; color: #2e7d32;'; ?>">
               Found
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px;">
        
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
                $status = $row['status'];
                $imgSource = !empty($row['image_path']) ? "../uploads/" . htmlspecialchars($row['image_path']) : "";
                
                $iconColor = ($status == 'lost') ? '#e74c3c' : '#27ae60';
        ?>
            <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.2s; border: 1px solid #f0f0f0;">
                
                <div style="height: 200px; background-color: #f8f9fa; position: relative; overflow: hidden;">
                    
                    <div style="position: absolute; top: 15px; left: 15px; z-index: 2; display: flex; flex-direction: column; gap: 5px;">
                        
                        <?php if ($status == 'lost'): ?>
                            <span style="background: #e74c3c; color: white; padding: 5px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; letter-spacing: 1px; border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                LOST
                            </span>

                        <?php elseif ($status == 'found'): ?>
                            <span style="background: #27ae60; color: white; padding: 5px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; letter-spacing: 1px; border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                FOUND
                            </span>

                        <?php elseif ($status == 'custody'): ?>
                            <span style="background: #27ae60; color: white; padding: 5px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; letter-spacing: 1px; border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                FOUND
                            </span>
                            <span style="background: #002746; color: white; padding: 5px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 700; letter-spacing: 1px; border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                                <i class="fas fa-shield-alt"></i> IN CUSTODY
                            </span>
                        <?php endif; ?>
                        
                    </div>
                    <?php if ($imgSource): ?>
                        <img src="<?php echo $imgSource; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #ccc;">
                            <i class="fas fa-image" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <div style="padding: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                        <h3 style="margin: 0; font-size: 1.2rem; color: #333; font-weight: 600;">
                            <?php echo htmlspecialchars($row['title']); ?>
                        </h3>
                        <span style="font-size: 0.8rem; color: #999; white-space: nowrap;">
                            <?php echo date('M d', strtotime($row['created_at'])); ?>
                        </span>
                    </div>

                    <div style="display: flex; gap: 15px; margin-bottom: 15px; font-size: 0.9rem; color: #666;">
                        <span style="display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-map-marker-alt" style="color: <?php echo $iconColor; ?>;"></i> 
                            <?php echo htmlspecialchars($row['location']); ?>
                        </span>
                        <span style="display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-tag" style="color: #7f8c8d;"></i> 
                            <?php echo htmlspecialchars($row['category']); ?>
                        </span>
                    </div>

                    <?php 
                    // Checking if current user is the poster
                    $is_my_post = ($row['user_id'] == $_SESSION['user_id']);
                    ?>

                    <?php if ($is_my_post): ?>
                        
                        <button disabled style="width: 100%; background: #95a5a6; color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 600; cursor: not-allowed;">
                            <i class="fas fa-user"></i> You Posted This
                        </button>

                    <?php elseif ($status == 'custody'): ?>

                        <button disabled style="width: 100%; background: #2c3e50; color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 600; cursor: default; opacity: 0.9;">
                            <i class="fas fa-university"></i> Visit Admin Office to Claim
                        </button>

                    <?php elseif ($status == 'lost'): ?>
                        
                        <a href="dashboard.php?page=contact_owner&item_id=<?php echo $row['item_id']; ?>" 
                           style="display: block; text-align: center; text-decoration: none; width: 100%; background: var(--primary-blue); color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            <i class="fas fa-search-location"></i> I Found This
                        </a>

                    <?php else: ?>
                        
                        <a href="dashboard.php?page=claim&item_id=<?php echo $row['item_id']; ?>" 
                           style="display: block; text-align: center; text-decoration: none; width: 100%; background: #27ae60; color: white; border: none; padding: 10px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                            <i class="fas fa-hand-paper"></i> Claim Item
                        </a>
                        
                    <?php endif; ?>

                </div>

                <div style="padding: 12px 20px; border-top: 1px solid #f9f9f9; display: flex; align-items: center; gap: 10px;">
                    <div style="width: 30px; height: 30px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold; color: #555;">
                        <?php echo getInitials($row['full_name']); ?>
                    </div>
                    <span style="font-size: 0.85rem; color: #777;">
                        Posted by <strong><?php echo htmlspecialchars($row['full_name']); ?></strong>
                    </span>
                </div>

            </div>
        <?php 
            }
        } else {
            echo "<div style='grid-column: 1/-1; padding: 40px; text-align: center; background: white; border-radius: 12px;'>
                    <i class='fas fa-search' style='font-size: 2rem; color: #ddd; margin-bottom: 15px;'></i>
                    <p style='color: #888;'>No items found matching your search.</p>
                  </div>";
        }
        ?>

    </div>
</div>