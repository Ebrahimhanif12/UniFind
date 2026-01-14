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
        <table class="activity-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $my_items_result->fetch_assoc()): ?>
                <tr>
                  <td>
                        <a href="dashboard.php?page=contact_owner&item_id=<?php echo $row['item_id']; ?>" 
                           style="color: var(--primary-blue); font-size: 0.9rem; margin-right: 10px; text-decoration: none;">
                           View
                        </a>

                       <?php if($row['status'] == 'lost'): ?>
                            <a href="../php/mark_returned.php?item_id=<?php echo $row['item_id']; ?>" 
                               onclick="return confirm('Mark this item as Returned? This will move it to history, but NOT delete it.');"
                               style="color: #27ae60; font-size: 0.9rem; font-weight: 600; text-decoration: none;">
                               <i class="fas fa-check"></i> Got it!
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="color: #666; text-align: center; padding: 20px;">You haven't reported any items yet.</p>
    <?php endif; ?>
</div>