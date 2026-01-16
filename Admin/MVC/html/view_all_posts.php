<?php
$sql = "SELECT items.*, users.full_name, users.student_id 
        FROM items 
        JOIN users ON items.user_id = users.user_id 
        ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="color: #2c3e50; margin: 0;">All System Posts</h2>
        <span style="background: #eef4ff; color: #1565c0; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
            Total: <?php echo $result->num_rows; ?>
        </span>
    </div>

    <table class="activity-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                <th style="padding: 12px; text-align: left;">ID</th>
                <th style="padding: 12px; text-align: left;">Item Details</th>
                <th style="padding: 12px; text-align: left;">Posted By</th>
                <th style="padding: 12px; text-align: left;">Status</th>
                <th style="padding: 12px; text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        
                        <td style="padding: 12px; color: #888; font-size: 0.9rem;">#<?php echo $row['item_id']; ?></td>
                        
                        <td style="padding: 12px;">
                            <strong style="color: #333;"><?php echo htmlspecialchars($row['title']); ?></strong>
                            <div style="font-size: 0.85rem; color: #888; margin-top: 4px;">
                                <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?>
                            </div>
                            <div style="font-size: 0.8rem; color: #aaa;">
                                <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                            </div>
                        </td>

                        <td style="padding: 12px;">
                            <div style="font-weight: 500; color: #444;"><?php echo htmlspecialchars($row['full_name']); ?></div>
                            <div style="font-size: 0.8rem; color: #999;"><?php echo htmlspecialchars($row['student_id']); ?></div>
                        </td>

                        <td style="padding: 12px;">
                            <?php 
                                $status = $row['status'];
                                $color = '#7f8c8d'; 
                                if($status == 'lost') $color = '#e74c3c'; 
                                if($status == 'found') $color = '#27ae60';
                                if($status == 'claimed') $color = '#8e44ad'; 
                            ?>
                            <span style="color: <?php echo $color; ?>; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; background: <?php echo $color; ?>15; padding: 4px 8px; border-radius: 4px;">
                                <?php echo $status; ?>
                            </span>
                        </td>

                        <td style="padding: 12px; text-align: center;">
                            <form action="../php/admin_delete_post.php" method="POST" onsubmit="return confirm('WARNING: Are you sure you want to permanently delete this post?');">
                                <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                                <button type="submit" style="background: #ffebee; color: #c62828; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; transition: background 0.2s;">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #999;">
                        No posts found in the system.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>