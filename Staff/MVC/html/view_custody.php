<?php
$incoming = $conn->query("SELECT items.*, users.full_name FROM items JOIN users ON items.user_id = users.user_id WHERE status = 'found' ORDER BY created_at DESC");

$in_custody = $conn->query("SELECT * FROM items WHERE status = 'custody' ORDER BY created_at DESC");
?>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    <div class="card-box" style="border-top: 4px solid #f39c12;">
        <h3 class="section-header" style="border-color: #f39c12;">
            <i class="fas fa-walking"></i> Incoming Drop-offs
        </h3>
        <p style="font-size: 0.85rem; color: #666; margin-bottom: 20px;">
            Students reported these found items. Wait for them to arrive at the office.
        </p>

        <table class="activity-table" style="width: 100%; border-collapse: collapse;">
            <tbody>
                <?php while($row = $incoming->fetch_assoc()): ?>
                <tr style="border-bottom: 1px solid #f0f0f0;">
                    <td style="padding: 12px;">
                        <strong style="color: #2c3e50;"><?php echo htmlspecialchars($row['title']); ?></strong>
                        <div style="font-size: 0.8rem; color: #888;">
                            Found by: <?php echo htmlspecialchars($row['full_name']); ?>
                        </div>
                    </td>
                    <td style="padding: 12px; text-align: right;">
                        <form action="../php/staff_receive_item.php" method="POST">
                            <input type="hidden" name="item_id" value="<?php echo $row['item_id']; ?>">
                            <button type="submit" onclick="return confirm('Confirm you physically received this item?');" 
                                style="background: #e3f2fd; color: #1565c0; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: bold;">
                                <i class="fas fa-hand-holding"></i> Receive
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="card-box" style="border-top: 4px solid #27ae60;">
        <h3 class="section-header" style="border-color: #27ae60;">
            <i class="fas fa-archive"></i> Secure Storage
        </h3>
        <p style="font-size: 0.85rem; color: #666; margin-bottom: 20px;">
            Items physically secured in the office. Print tags for organization.
        </p>

        <table class="activity-table" style="width: 100%; border-collapse: collapse;">
            <tbody>
                <?php while($row = $in_custody->fetch_assoc()): ?>
                <tr style="border-bottom: 1px solid #f0f0f0;">
                    <td style="padding: 12px;">
                        <strong style="color: #2c3e50;"><?php echo htmlspecialchars($row['title']); ?></strong>
                        <div style="margin-top: 4px;">
                            <span style="background: #27ae60; color: white; padding: 2px 6px; border-radius: 4px; font-size: 0.7rem;">SECURE</span>
                            <span style="font-size: 0.8rem; color: #888;">ID: #<?php echo $row['item_id']; ?></span>
                        </div>
                    </td>
                    <td style="padding: 12px; text-align: right;">
                        <a href="dashboard.php?page=generate_qr&id=<?php echo $row['item_id']; ?>" target="_blank"
                           style="background: #34495e; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; margin-right: 5px; display: inline-block;">
                           <i class="fas fa-qrcode"></i> QR
                        </a>
                        
                        <a href="../php/staff_return_item.php?id=<?php echo $row['item_id']; ?>" 
                           onclick="return confirm('Is the owner here to pick it up?');"
                           style="background: #e74c3c; color: white; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; display: inline-block;">
                           <i class="fas fa-check"></i> Return
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>