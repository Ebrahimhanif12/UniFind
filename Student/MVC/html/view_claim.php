<?php
if (!isset($_GET['item_id'])) {
    echo "Item ID missing.";
    exit();
}

$item_id = $conn->real_escape_string($_GET['item_id']);
$sql = "SELECT * FROM items WHERE item_id = '$item_id' AND status = 'found'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<h3 style='color:red; text-align:center;'>Item not found or unavailable.</h3>";
} else {
    $item = $result->fetch_assoc();
?>

<div style="width: 100%; max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
    
    <div style="text-align: center; margin-bottom: 30px;">
        <div style="width: 60px; height: 60px; background: #e8f5e9; color: #27ae60; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 1.5rem;">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h2 style="color: #333; margin: 0;">Security Check</h2>
    </div>

    <div style="background: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 25px; border-left: 4px solid #27ae60;">
        <h4 style="margin: 0 0 5px; color: #333;">Item: <?php echo htmlspecialchars($item['title']); ?></h4>
        <p style="margin: 0; font-size: 0.9rem; color: #555;">Found at: <?php echo htmlspecialchars($item['location']); ?></p>
    </div>

    <?php if (isset($_SESSION['claim_success'])): ?>
        
        <div style="background: #e8f5e9; padding: 25px; border-radius: 12px; text-align: center; border: 1px solid #a5d6a7;">
            <h3 style="color: #2e7d32; margin-top: 0;">Verified Ownership! <i class="fas fa-check-circle"></i></h3>
            <p style="color: #444; margin-bottom: 20px;">You have correctly answered the security question. Please contact the finder below to collect your item.</p>
            
            <div style="background: white; padding: 15px; border-radius: 8px; text-align: left; display: inline-block; width: 100%; box-sizing: border-box;">
                <p style="margin: 5px 0;"><strong>Name:</strong> <?php echo htmlspecialchars($_SESSION['claim_success']['name']); ?></p>
                <p style="margin: 5px 0;"><strong>Student ID:</strong> <?php echo htmlspecialchars($_SESSION['claim_success']['student_id']); ?></p>
                <p style="margin: 5px 0;"><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($_SESSION['claim_success']['email']); ?>"><?php echo htmlspecialchars($_SESSION['claim_success']['email']); ?></a></p>
            </div>

            <a href="dashboard.php?page=feed" class="btn-primary" style="display: block; margin-top: 20px; text-decoration: none; background: #2e7d32;">
                Back to Feed
            </a>
        </div>

    <?php else: ?>

        <?php if (isset($_SESSION['claim_error'])): ?>
            <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 0.9rem; border: 1px solid #ef9a9a;">
                <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['claim_error']; ?>
            </div>
        <?php endif; ?>

        <form action="../php/claim_control.php" method="POST">
            <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
            
            <div class="form-group">
                <label style="font-weight: 600; color: #27ae60; display: block; margin-bottom: 10px;">
                    <i class="fas fa-question-circle"></i> Security Question:
                </label>
                <div style="font-size: 1.1rem; font-weight: 500; color: #333; padding: 15px; background: #fff; border: 2px dashed #ddd; border-radius: 8px; margin-bottom: 20px;">
                    "<?php echo htmlspecialchars($item['security_question']); ?>"
                </div>
            </div>

            <div class="form-group">
                <label style="font-weight: 600; color: #555; display: block; margin-bottom: 8px;">Your Answer:</label>
                <input type="text" name="answer" class="form-control" placeholder="Type your answer here..." required 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 1rem;">
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; margin-top: 20px; background: #27ae60; border: none; padding: 12px; font-size: 1rem;">
                Verify & Claim
            </button>
            
            <a href="dashboard.php?page=feed" style="display: block; text-align: center; margin-top: 15px; color: #888; text-decoration: none;">Cancel</a>
        </form>

    <?php endif; ?>

</div>

<?php 
unset($_SESSION['claim_error']);
unset($_SESSION['claim_success']);
?>

<?php } ?>