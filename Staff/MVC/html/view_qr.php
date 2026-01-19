<?php
if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $item = $conn->query("SELECT * FROM items WHERE item_id='$id'")->fetch_assoc();
}

if (!$item) die("Item not found");

$qr_data = "UniFind Item #" . $item['item_id'] . " - " . $item['title'];
$qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qr_data);
?>

<div style="background: white; padding: 40px; border-radius: 12px; text-align: center; max-width: 400px; margin: 20px auto; border: 2px dashed #333;">
    
    <h2 style="color: #002746; margin-bottom: 5px;">UniFind Custody Tag</h2>
    <p style="color: #666; margin-top: 0;">Official Campus Property</p>
    
    <img src="<?php echo $qr_url; ?>" alt="QR Code" style="margin: 20px 0; border: 1px solid #ddd; padding: 10px;">
    
    <div style="text-align: left; background: #f9f9f9; padding: 15px; border-radius: 8px;">
        <p><strong>ID:</strong> #<?php echo $item['item_id']; ?></p>
        <p><strong>Item:</strong> <?php echo htmlspecialchars($item['title']); ?></p>
        <p><strong>Category:</strong> <?php echo htmlspecialchars($item['category']); ?></p>
        <p><strong>Date:</strong> <?php echo date('d M Y'); ?></p>
    </div>

    <button onclick="window.print()" style="margin-top: 20px; background: #002746; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer;">
        <i class="fas fa-print"></i> Print Tag
    </button>
</div>