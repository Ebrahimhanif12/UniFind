<?php
$settings = [];
$res = $conn->query("SELECT * FROM system_settings");
while($row = $res->fetch_assoc()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}

$announcement = $conn->query("SELECT * FROM announcements ORDER BY id DESC LIMIT 1")->fetch_assoc();
$ann_msg = $announcement ? $announcement['message'] : '';
$ann_active = $announcement ? $announcement['is_active'] : 0;
$ann_type = $announcement ? $announcement['type'] : 'info';
?>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

    <div class="card-box">
        <h3 class="section-header" style="border-bottom: 2px solid #eee; padding-bottom: 10px;">
            <i class="fas fa-toggle-on"></i> Feature Control
        </h3>
        <p style="font-size: 0.9rem; color: #666; margin-bottom: 20px;">
            Temporarily disable system features during maintenance.
        </p>

        <form action="../php/save_settings.php" method="POST">
            <input type="hidden" name="action" value="update_features">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; padding: 10px; background: #f9f9f9; border-radius: 8px;">
                <span style="font-weight: 600; color: #444;">Allow New Posts</span>
                <label class="switch">
                    <input type="checkbox" name="enable_posting" <?php echo ($settings['enable_posting'] ?? 1) ? 'checked' : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding: 10px; background: #f9f9f9; border-radius: 8px;">
                <span style="font-weight: 600; color: #444;">Allow Student Signup</span>
                <label class="switch">
                    <input type="checkbox" name="enable_signup" <?php echo ($settings['enable_signup'] ?? 1) ? 'checked' : ''; ?>>
                    <span class="slider round"></span>
                </label>
            </div>

            <button type="submit" style="width: 100%; background: #27ae60; color: white; border: none; padding: 12px; border-radius: 6px; font-weight: bold; cursor: pointer;">
                Save Changes
            </button>
        </form>
    </div>

    <div class="card-box">
        <h3 class="section-header" style="border-bottom: 2px solid #27ae60; padding-bottom: 10px;">
            <i class="fas fa-bullhorn"></i> Global Announcement
        </h3>
        <p style="font-size: 0.9rem; color: #666; margin-bottom: 20px;">
            Display a banner message at the top of every dashboard.
        </p>

        <form action="../php/save_settings.php" method="POST">
            <input type="hidden" name="action" value="update_announcement">

            <label style="font-weight: 600; color: #444; display: block; margin-bottom: 5px;">Message:</label>
            <textarea name="message" rows="3" placeholder="e.g. Library will be closed tomorrow..." 
                      style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ddd; margin-bottom: 15px; box-sizing: border-box;"><?php echo htmlspecialchars($ann_msg); ?></textarea>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                
                <div>
                    <label style="font-weight: 600; color: #444; display: block; margin-bottom: 5px;">Status:</label>
                    <select name="is_active" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ddd;">
                        <option value="1" <?php echo $ann_active ? 'selected' : ''; ?>>Active (Visible)</option>
                        <option value="0" <?php echo !$ann_active ? 'selected' : ''; ?>>Inactive (Hidden)</option>
                    </select>
                </div>

                <div>
                    <label style="font-weight: 600; color: #444; display: block; margin-bottom: 5px;">Banner Type:</label>
                    <select name="type" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ddd;">
                        <option value="info" <?php echo ($ann_type == 'info') ? 'selected' : ''; ?>>🔵 Info (Blue)</option>
                        <option value="warning" <?php echo ($ann_type == 'warning') ? 'selected' : ''; ?>>🟠 Warning (Orange)</option>
                        <option value="danger" <?php echo ($ann_type == 'danger') ? 'selected' : ''; ?>>🔴 Urgent (Red)</option>
                    </select>
                </div>
            </div>

            <button type="submit" style="width: 100%; background: #27ae60; color: white; border: none; padding: 12px; border-radius: 6px; font-weight: bold; cursor: pointer;">
                Update Banner
            </button>
        </form>
    </div>

    <div style="grid-column: 1 / -1; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h3 style="color: var(--uni-primary); margin: 0 0 10px 0;"><i class="fas fa-database"></i> Database Backup</h3>
            <p style="color: #666; margin: 0;">Download a full SQL dump of the current database state.</p>
        </div>
        <a href="../php/backup_db.php" style="background: #27ae60; color: white; text-decoration: none; padding: 12px 25px; border-radius: 6px; font-weight: bold; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-download"></i> Download Backup
        </a>
    </div>

</div>

<style>
.switch { position: relative; display: inline-block; width: 50px; height: 24px; }
.switch input { opacity: 0; width: 0; height: 0; }
.slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 24px; }
.slider:before { position: absolute; content: ""; height: 16px; width: 16px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; }
input:checked + .slider { background-color: var(--uni-primary); }
input:checked + .slider:before { transform: translateX(26px); }
</style>