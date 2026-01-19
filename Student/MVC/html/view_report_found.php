<div style="width: 100%; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); box-sizing: border-box;">
    
    <h2 style="color: #27ae60; margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
        Report a Found Item
    </h2>
    
    <p style="margin-bottom: 20px; color: #666; font-size: 0.9rem; background: #e8f5e9; padding: 15px; border-radius: 8px; border-left: 4px solid #27ae60;">
        <strong>Tip:</strong> Please provide a "Security Question" (e.g., "What is the wallpaper?") so the real owner can verify the item is theirs.
    </p>

    <form action="../php/report_found_control.php" method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
        
        <div class="form-group" style="grid-column: span 2;">
            <label style="font-weight: 600; color: #555; display: block; margin-bottom: 8px;">What did you find?</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Black iPhone 13" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
        </div>

        <div class="form-group">
            <label style="font-weight: 600; color: #555; display: block; margin-bottom: 8px;">Category</label>
            <select name="category" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
                <option value="Electronics">Electronics</option>
                <option value="Documents">Documents (ID/Wallet)</option>
                <option value="Clothing">Clothing</option>
                <option value="Accessories">Accessories</option>
                <option value="Others">Others</option>
            </select>
        </div>

        <div class="form-group">
            <label style="font-weight: 600; color: #555; display: block; margin-bottom: 8px;">Date Found</label>
            <input type="date" name="lost_date" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
        </div>

        <div class="form-group" style="grid-column: span 2;">
            <label style="font-weight: 600; color: #555; display: block; margin-bottom: 8px;">Location Found</label>
            <input type="text" name="location" class="form-control" placeholder="e.g. Library, 3rd Floor Table" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
        </div>

        <div class="form-group" style="grid-column: span 2;">
            <label style="font-weight: 600; color: #555; display: block; margin-bottom: 8px;">Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Describe the item..." style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; resize: vertical;"></textarea>
        </div>

        <div class="form-group">
            <label style="font-weight: 600; color: #27ae60; display: block; margin-bottom: 8px;">Security Question</label>
            <input type="text" name="security_question" class="form-control" placeholder="e.g. What is the lockscreen wallpaper?" required style="width: 100%; padding: 12px; border: 1px solid #27ae60; border-radius: 6px;">
        </div>

        <div class="form-group">
            <label style="font-weight: 600; color: #27ae60; display: block; margin-bottom: 8px;">Answer (Only you see this)</label>
            <input type="text" name="security_answer" class="form-control" placeholder="e.g. Spiderman" required style="width: 100%; padding: 12px; border: 1px solid #27ae60; border-radius: 6px;">
        </div>

        <div class="form-group" style="grid-column: span 2;">
            <label style="font-weight: 600; color: #555; display: block; margin-bottom: 8px;">Upload Image</label>
            <input type="file" name="item_image" class="form-control" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background: #f9f9f9;">
        </div>

        <div class="form-group" style="grid-column: span 2;">
            <button type="submit" class="btn-primary" style="padding: 12px 30px; font-size: 1rem; background-color: #27ae60; border: none;">Post Found Item</button>
        </div>

    </form>
</div>