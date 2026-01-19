<div style="width: 100%; background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); box-sizing: border-box;">
    
    <h2 style="color: var(--primary-blue); margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
        Submit a Lost Report
    </h2>
    
    <form action="../php/report_lost_control.php" method="POST" enctype="multipart/form-data" style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
        
        <div class="form-group" style="grid-column: span 2;">
            <label style="font-weight: 600; color: #555; display: block; margin-bottom: 8px;">What did you lose?</label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Blue Water Bottle" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
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
            <label style="font-weight: 600; color: #555; display: block; margin-bottom: 8px;">Date Lost</label>
            <input type="date" name="lost_date" class="form-control" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
        </div>

        <div class="form-group" style="grid-column: span 2;">
            <label style="font-weight: 600; color: #555; display: block; margin-bottom: 8px;">Location</label>
            <input type="text" name="location" class="form-control" placeholder="e.g. Annex 1, Room 3102" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
        </div>

        <div class="form-group" style="grid-column: span 2;">
            <label style="font-weight: 600; color: #555; display: block; margin-bottom: 8px;">Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Describe color, brand, or unique marks..." style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; resize: vertical;"></textarea>
        </div>

        <div class="form-group" style="grid-column: span 2;">
            <label style="font-weight: 600; color: #555; display: block; margin-bottom: 8px;">Upload Image (Optional)</label>
            <input type="file" name="item_image" class="form-control" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; background: #f9f9f9;">
        </div>

        <div class="form-group" style="grid-column: span 2;">
            <button type="submit" class="btn-primary" style="padding: 12px 30px; font-size: 1rem;">Submit Report</button>
        </div>

    </form>
</div>