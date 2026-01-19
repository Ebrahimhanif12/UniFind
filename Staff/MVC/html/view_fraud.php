<?php
$fraud_sql = "SELECT c.claimant_id, u.full_name, u.student_id, u.is_banned, COUNT(c.claim_id) as fail_count 
              FROM claims c 
              JOIN users u ON c.claimant_id = u.user_id 
              WHERE c.status = 'rejected' 
              GROUP BY c.claimant_id 
              HAVING fail_count >= 3 
              ORDER BY fail_count DESC";
$fraudsters = $conn->query($fraud_sql);

$recent_posts = $conn->query("SELECT * FROM items WHERE status IN ('lost', 'found') ORDER BY created_at DESC LIMIT 10");
?>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    <div class="card-box" style="border-top: 4px solid #c0392b;">
        <h3 class="section-header" style="border-color: #c0392b; color: #c0392b;">
            <i class="fas fa-user-slash"></i> Suspicious Users
        </h3>
        <p style="font-size: 0.85rem; color: #666; margin-bottom: 20px;">
            Students with 3+ failed claims. Banning them prevents login.
        </p>

        <table class="activity-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #fdf2f2; border-bottom: 2px solid #eee;">
                    <th style="padding: 10px; text-align: left;">Student</th>
                    <th style="padding: 10px; text-align: center;">Fails</th>
                    <th style="padding: 10px; text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
<?php while($row = $fraudsters->fetch_assoc()): ?>
    <tr style="border-bottom: 1px solid #f0f0f0;">
        <td style="padding: 12px;">
            <strong><?php echo htmlspecialchars($row['full_name']); ?></strong><br>
            <span style="font-size: 0.8rem; color: #888;"><?php echo htmlspecialchars($row['student_id']); ?></span>
        </td>
        <td style="padding: 12px; text-align: center;">
            <span style="background: #c0392b; color: white; padding: 2px 8px; border-radius: 10px; font-weight: bold;">
                <?php echo $row['fail_count']; ?>
            </span>
        </td>
        <td style="padding: 12px; text-align: right;">
                
                <?php if ($row['is_banned'] == 1): ?>
                    <a href="../php/staff_unban_user.php?id=<?php echo $row['claimant_id']; ?>" 
                       onclick="return confirm('UNBAN this user? They will be allowed to login again.');"
                       style="background: #27ae60; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem;">
                       <i class="fas fa-unlock"></i> Unban
                    </a>

                <?php else: ?>
                    <a href="../php/staff_ban_user.php?id=<?php echo $row['claimant_id']; ?>" 
                       onclick="return confirm('BAN this user? They will immediately be logged out.');"
                       style="background: #333; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.8rem;">
                       <i class="fas fa-gavel"></i> Ban User
                    </a>
                <?php endif; ?>

            </td>
    </tr>
    <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="card-box" style="border-top: 4px solid #f39c12;">
        <h3 class="section-header" style="border-color: #f39c12; color: #e67e22;">
            <i class="fas fa-images"></i> Content Review
        </h3>
        <p style="font-size: 0.85rem; color: #666; margin-bottom: 20px;">
            Quickly remove spam or inappropriate images.
        </p>

        <div style="display: flex; flex-direction: column; gap: 15px; max-height: 500px; overflow-y: auto;">
            <?php while($item = $recent_posts->fetch_assoc()): ?>
                <div style="display: flex; align-items: center; gap: 15px; padding: 10px; border: 1px solid #eee; border-radius: 8px;">
                    
                    <div style="width: 60px; height: 60px; background: #eee; border-radius: 6px; overflow: hidden; flex-shrink: 0;">
                        <?php if(!empty($item['image_path'])): ?>
                            <img src="../../../Student/MVC/uploads/<?php echo htmlspecialchars($item['image_path']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #ccc;"><i class="fas fa-image"></i></div>
                        <?php endif; ?>
                    </div>

                    <div style="flex-grow: 1;">
                        <div style="font-weight: 600; color: #2c3e50; font-size: 0.9rem;"><?php echo htmlspecialchars($item['title']); ?></div>
                        <div style="font-size: 0.8rem; color: #888;"><?php echo htmlspecialchars($item['description']); ?></div>
                    </div>

                    <form action="../php/staff_delete_spam.php" method="POST" onsubmit="return confirm('Remove as SPAM?');">
                        <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                        <button type="submit" style="color: #c0392b; background: #fdeaea; border: none; padding: 8px; border-radius: 6px; cursor: pointer;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>

                </div>
            <?php endwhile; ?>
        </div>
    </div>

</div>