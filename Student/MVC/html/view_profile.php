<?php
$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE user_id = '$user_id'")->fetch_assoc();

$img_src = !empty($user['profile_image']) ? "../uploads/" . $user['profile_image'] : "";
?>

<div style="max-width: 800px; margin: 0 auto;">
    
    <div class="card-box" style="padding: 40px;">
        <h2 style="color: #002746; margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 10px;">
            <i class="fas fa-user-cog"></i> Profile Settings
        </h2>

        <?php if (isset($_GET['success'])): ?>
            <div style="background: #e8f5e9; color: #27ae60; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <i class="fas fa-check-circle"></i> Profile updated successfully!
            </div>
        <?php endif; ?>

        <form action="../php/update_profile.php" method="POST" enctype="multipart/form-data">
            
            <div style="display: flex; align-items: center; gap: 30px; margin-bottom: 40px;">
                
                <div style="
                    width: 120px; height: 120px; 
                    border-radius: 50%; 
                    overflow: hidden; 
                    background: #f0f0f0; 
                    border: 4px solid white; 
                    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
                    display: flex; align-items: center; justify-content: center;
                ">
                    <?php if ($img_src): ?>
                        <img src="<?php echo $img_src; ?>" style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <span style="font-size: 3rem; color: #ccc; font-weight: bold;">
                            <?php echo substr($user['full_name'], 0, 1); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <div>
                    <label style="font-weight: 600; color: #444; display: block; margin-bottom: 8px;">Profile Photo</label>
                    <input type="file" name="profile_image" accept="image/*" 
                           style="background: #f9f9f9; padding: 10px; border-radius: 6px; border: 1px solid #ddd; width: 100%;">
                    <p style="font-size: 0.8rem; color: #888; margin-top: 5px;">Accepts JPG, PNG. Max 2MB.</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="font-weight: 600; color: #888;">Full Name (Locked)</label>
                    <input type="text" value="<?php echo htmlspecialchars($user['full_name']); ?>" disabled
                           style="width: 100%; padding: 12px; background: #eee; border: 1px solid #ddd; border-radius: 6px; color: #666; cursor: not-allowed;">
                </div>
                <div>
                    <label style="font-weight: 600; color: #888;">Registered Email (Locked)</label>
                    <input type="text" value="<?php echo htmlspecialchars($user['email']); ?>" disabled
                           style="width: 100%; padding: 12px; background: #eee; border: 1px solid #ddd; border-radius: 6px; color: #666; cursor: not-allowed;">
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="font-weight: 600; color: #002746;">Nickname / Display Name</label>
                <input type="text" name="nickname" value="<?php echo htmlspecialchars($user['nickname'] ?? ''); ?>" placeholder="What should we call you?"
                       style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; margin-top: 5px;">
            </div>

            <div style="margin-bottom: 30px;">
                <label style="font-weight: 600; color: #002746;">Phone Number</label>
                <input type="text" name="phone_number" value="<?php echo htmlspecialchars($user['phone_number'] ?? ''); ?>" placeholder="017..."
                       style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; margin-top: 5px;">
            </div>

            <button type="submit" class="btn-primary" style="padding: 12px 30px; font-size: 1rem;">
                <i class="fas fa-save"></i> Save Changes
            </button>

        </form>
    </div>
</div>