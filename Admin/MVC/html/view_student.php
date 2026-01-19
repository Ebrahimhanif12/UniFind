<?php
$sql = "SELECT * FROM users WHERE role = 'student' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="color: #2c3e50; margin: 0;">Registered Students</h3>
        <span style="background: #e3f2fd; color: #1565c0; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">
            Total: <?php echo $result->num_rows; ?>
        </span>
    </div>
    
    <table class="activity-table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                <th style="padding: 12px; text-align: left;">Student ID</th>
                <th style="padding: 12px; text-align: left;">Name</th>
                <th style="padding: 12px; text-align: left;">Email</th>
                <th style="padding: 12px; text-align: center;">Karma</th>
                <th style="padding: 12px; text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr style="border-bottom: 1px solid #f0f0f0;">
                    <td style="padding: 12px; color: #888; font-weight: 600;">
                        <?php echo htmlspecialchars($row['student_id']); ?>
                    </td>
                    <td style="padding: 12px;">
                        <strong><?php echo htmlspecialchars($row['full_name']); ?></strong>
                    </td>
                    <td style="padding: 12px; color: #555;">
                        <?php echo htmlspecialchars($row['email']); ?>
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        <span style="background: #f3e5f5; color: #8e44ad; padding: 4px 10px; border-radius: 12px; font-weight: bold; font-size: 0.85rem;">
                            <?php echo $row['karma_points']; ?> pts
                        </span>
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        <a href="../php/admin_delete_student.php?id=<?php echo $row['user_id']; ?>" 
                           onclick="return confirm('WARNING: This will delete the student and ALL their posts. This cannot be undone. Continue?');"
                           style="color: #c62828; text-decoration: none; font-size: 0.9rem; padding: 6px 10px; background: #ffebee; border-radius: 4px;">
                           <i class="fas fa-trash-alt"></i> Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #999;">
                        No students registered yet.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>