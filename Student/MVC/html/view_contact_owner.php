<?php
if (!isset($_GET['item_id'])) {
    echo "Item ID missing.";
    exit();
}

$item_id = $conn->real_escape_string($_GET['item_id']);

$sql = "SELECT items.*, users.full_name, users.email, users.student_id 
        FROM items 
        JOIN users ON items.user_id = users.user_id 
        WHERE item_id = '$item_id' AND status = 'lost'";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<h3 style='color:red; text-align:center;'>Item not found or unavailable.</h3>";
} else {
    $row = $result->fetch_assoc();
?>

<div style="width: 100%; max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
    
    <div style="text-align: center; margin-bottom: 30px;">
        <div style="width: 60px; height: 60px; background: #eef4ff; color: var(--primary-blue); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 1.5rem;">
            <i class="fas fa-user-check"></i>
        </div>
        <h2 style="color: #333; margin: 0;">Help Return This Item</h2>
        <p style="color: #666;">Thank you for being a good Samaritan!</p>
    </div>

    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid var(--primary-blue);">
        <h4 style="margin: 0 0 5px; color: #333;">Item: <?php echo htmlspecialchars($row['title']); ?></h4>
        <p style="margin: 0; font-size: 0.9rem; color: #555;">Lost at: <?php echo htmlspecialchars($row['location']); ?></p>
    </div>

    <div style="background: white; border: 1px solid #eee; border-radius: 12px; padding: 25px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
        <h3 style="color: #333; margin-top: 0; font-size: 1.2rem;">Owner Contact Info</h3>
        <p style="color: #777; font-size: 0.9rem; margin-bottom: 20px;">Please contact the student below to arrange a return.</p>
        
        <div style="text-align: left; background: #fdfdfd; padding: 15px; border-radius: 8px; border: 1px solid #f0f0f0;">
            <p style="margin: 8px 0; border-bottom: 1px solid #f0f0f0; padding-bottom: 8px;">
                <strong style="color: #555; width: 80px; display: inline-block;">Name:</strong> 
                <?php echo htmlspecialchars($row['full_name']); ?>
            </p>
            <p style="margin: 8px 0; border-bottom: 1px solid #f0f0f0; padding-bottom: 8px;">
                <strong style="color: #555; width: 80px; display: inline-block;">ID:</strong> 
                <?php echo htmlspecialchars($row['student_id']); ?>
            </p>
            <p style="margin: 8px 0;">
                <strong style="color: #555; width: 80px; display: inline-block;">Email:</strong> 
                <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" style="color: var(--primary-blue); text-decoration: none; font-weight: 500;">
                    <?php echo htmlspecialchars($row['email']); ?>
                </a>
            </p>
        </div>

        <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>?subject=Found Item: <?php echo htmlspecialchars($row['title']); ?>" 
           class="btn-primary" 
           style="display: block; margin-top: 20px; text-decoration: none; padding: 12px;">
           <i class="fas fa-envelope"></i> Send Email Now
        </a>
    </div>

    <a href="dashboard.php?page=feed" style="display: block; text-align: center; margin-top: 20px; color: #888; text-decoration: none;">Back to Feed</a>

</div>

<?php } ?>