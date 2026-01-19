<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon icon-blue"><i class="fas fa-box-open"></i></div>
        <div><h3><?php echo $total_posts; ?></h3><p>My Posts</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-gold"><i class="fas fa-exclamation-circle"></i></div>
        <div><h3>0</h3><p>Pending</p></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-green"><i class="fas fa-check-circle"></i></div>
        <div><h3>0</h3><p>Recovered</p></div>
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

<div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); width: 100%;">
    <h2 style="margin-bottom: 20px; color: var(--primary-blue);">My Recent Activity</h2>
    
    <?php if ($total_posts > 0): ?>
        <table class="activity-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                    <th style="padding: 12px; text-align: left;">Item</th>
                    <th style="padding: 12px; text-align: left;">Date</th>
                    <th style="padding: 12px; text-align: left;">Status</th>
                    <th style="padding: 12px; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $my_items_result->fetch_assoc()): ?>
                <tr style="border-bottom: 1px solid #f0f0f0;">
                    
                    <td style="padding: 12px;">
                        <strong style="color: #333; display: block;"><?php echo htmlspecialchars($row['title']); ?></strong>
                        <span style="font-size: 0.85rem; color: #888;">
                            <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['location']); ?>
                        </span>
                    </td>

                    <td style="padding: 12px; color: #666;">
                        <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                    </td>

                    <td style="padding: 12px;">
                        <?php 
                        $st = $row['status'];
                        if($st == 'lost') echo '<span style="background:#ffebee; color:#c62828; padding:4px 8px; border-radius:4px; font-size:0.8rem; font-weight:600;">LOST</span>';
                        elseif($st == 'found') echo '<span style="background:#e8f5e9; color:#2e7d32; padding:4px 8px; border-radius:4px; font-size:0.8rem; font-weight:600;">FOUND</span>';
                        elseif($st == 'custody') echo '<span style="background:#e3f2fd; color:#1565c0; padding:4px 8px; border-radius:4px; font-size:0.8rem; font-weight:600;">IN CUSTODY</span>';
                        elseif($st == 'claimed') echo '<span style="background:#f3e5f5; color:#7b1fa2; padding:4px 8px; border-radius:4px; font-size:0.8rem; font-weight:600;">RESOLVED</span>';
                        ?>
                    </td>

                    <td style="padding: 12px; text-align: center;">
                        <div style="display: flex; gap: 10px; justify-content: center;">
                            
                            <a href="dashboard.php?page=feed&search=<?php echo urlencode($row['title']); ?>" 
                               style="color: var(--primary-blue); background: #e3f2fd; padding: 6px 10px; border-radius: 6px; font-size: 0.85rem; text-decoration: none;">
                               <i class="fas fa-eye"></i>
                            </a>

                            <?php if($row['status'] == 'lost'): ?>
                                <a href="../php/mark_returned.php?item_id=<?php echo $row['item_id']; ?>" 
                                   onclick="return confirm('Mark as Recovered?');"
                                   style="color: #27ae60; background: #e8f5e9; padding: 6px 10px; border-radius: 6px; font-size: 0.85rem; text-decoration: none;" title="I found my item">
                                   <i class="fas fa-check"></i>
                                </a>
                                <a href="generate_poster.php?item_id=<?php echo $row['item_id']; ?>" target="_blank"
                               style="color: #fff; background: #e67e22; padding: 6px 10px; border-radius: 6px; font-size: 0.85rem; text-decoration: none; margin-left: 5px;" 
                                title="Generate Poster">
                            <i class="fas fa-file-pdf"></i> Poster
                          </a>
                            <?php endif; ?>

                            <a href="../php/delete_post.php?id=<?php echo $row['item_id']; ?>" 
                               onclick="return confirm('Delete this post?');"
                               style="color: #c62828; background: #ffebee; padding: 6px 10px; border-radius: 6px; font-size: 0.85rem; text-decoration: none;">
                               <i class="fas fa-trash"></i>
                            </a>

                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="text-align: center; padding: 40px; color: #888;">
            <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 10px; color: #eee;"></i>
            <p>You haven't posted any items yet.</p>
        </div>
    <?php endif; ?>
</div>