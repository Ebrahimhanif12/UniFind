<?php
$sql = "SELECT admin_logs.*, users.full_name 
        FROM admin_logs 
        JOIN users ON admin_logs.admin_id = users.user_id 
        ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
    <h2 style="color: #2c3e50; margin-bottom: 20px;">Global Activity Logs</h2>
    
    <table class="activity-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                <th style="padding: 12px;">Time</th>
                <th style="padding: 12px;">Admin</th>
                <th style="padding: 12px;">Action</th>
                <th style="padding: 12px;">Details</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 12px; color: #888; font-size: 0.85rem;">
                            <?php echo $row['created_at']; ?>
                        </td>
                        <td style="padding: 12px; font-weight: 600;">
                            <?php echo htmlspecialchars($row['full_name']); ?>
                        </td>
                        <td style="padding: 12px;">
                            <span style="background: #e3f2fd; color: #1565c0; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; font-weight: bold;">
                                <?php echo $row['action_type']; ?>
                            </span>
                        </td>
                        <td style="padding: 12px; color: #555;">
                            <?php echo htmlspecialchars($row['description']); ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center; padding:20px;">No activity recorded yet.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>