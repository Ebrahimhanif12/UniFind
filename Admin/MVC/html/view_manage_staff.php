<?php
$sql = "SELECT * FROM users WHERE role = 'staff' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div class="stats-grid" style="grid-template-columns: 2fr 1fr;">
    
    <div class="card-box">
        <h3 class="section-header">University Staff List</h3>
        
        <table class="activity-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                    <th style="padding: 10px; text-align: left;">Name</th>
                    <th style="padding: 10px; text-align: left;">Email</th>
                    <th style="padding: 10px; text-align: left;">Staff ID</th>
                    <th style="padding: 10px; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr style="border-bottom: 1px solid #f0f0f0;">
                        <td style="padding: 12px; font-weight: 600;"><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td style="padding: 12px; color: #555;"><?php echo htmlspecialchars($row['email']); ?></td>
                        <td style="padding: 12px; color: #888; font-size: 0.85rem;"><?php echo htmlspecialchars($row['student_id']); ?></td>
                        <td style="padding: 12px; text-align: center;">
                            <a href="../php/remove_staff.php?id=<?php echo $row['user_id']; ?>" 
                               onclick="return confirm('Are you sure you want to remove this staff member?');"
                               style="color: #c62828; text-decoration: none; font-size: 0.9rem; padding: 5px 10px; background: #ffebee; border-radius: 4px;">
                               <i class="fas fa-trash-alt"></i> Remove
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="padding:20px; text-align:center; color:#999;">No staff accounts found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div style="background: var(--uni-primary); padding: 30px; border-radius: 12px; color: white;">
        <h3 style="margin-top: 0; color: white; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; margin-bottom: 20px;">
            <i class="fas fa-user-plus"></i> Add New Staff
        </h3>
        
        <form action="../php/add_staff.php" method="POST">
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 0.85rem; margin-bottom: 5px; color: #bdc3c7;">Full Name</label>
                <input type="text" name="full_name" required placeholder="e.g. John Doe" style="width: 100%; padding: 10px; border-radius: 6px; border: none;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label style="display: block; font-size: 0.85rem; margin-bottom: 5px; color: #bdc3c7;">University Email</label>
                <input type="email" name="email" required placeholder="staff@uni.edu" style="width: 100%; padding: 10px; border-radius: 6px; border: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 0.85rem; margin-bottom: 5px; color: #bdc3c7;">Default Password</label>
                <input type="text" name="password" value="Staff123" readonly style="width: 100%; padding: 10px; border-radius: 6px; border: 1px dashed #bdc3c7; background: transparent; color: #ecf0f1; cursor: not-allowed;">
                <small style="color: #95a5a6; font-size: 0.75rem;">Staff can change this after login.</small>
            </div>

            <button type="submit" style="width: 100%; background: #27ae60; color: white; border: none; padding: 12px; border-radius: 6px; font-weight: bold; cursor: pointer; transition: background 0.3s;">
                Create Account
            </button>
        </form>
    </div>
</div>