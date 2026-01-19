<?php
session_start();
include '../db/db_conn.php';

if (!isset($_GET['item_id'])) {
    die("Item ID missing.");
}

$item_id = $conn->real_escape_string($_GET['item_id']);
$sql = "SELECT items.*, users.full_name, users.phone_number, users.email 
        FROM items 
        JOIN users ON items.user_id = users.user_id 
        WHERE items.item_id = '$item_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Item not found.");
}

$item = $result->fetch_assoc();
$qr_data = "Found this item? Contact: " . $item['email']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Missing Poster - <?php echo htmlspecialchars($item['title']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background: #555;
            margin: 0;
            padding: 20px;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            display: flex;
            justify-content: center;
        }

        .poster-sheet {
            background: white;
            width: 210mm; 
            height: 297mm; 
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
            text-align: center;
            position: relative;
            box-sizing: border-box;
            overflow: hidden; 
            display: flex;
            flex-direction: column;
            justify-content: space-between; 
        }

        .header-banner {
            background: #c0392b;
            color: white;
            font-size: 4rem; 
            font-weight: 900;
            padding: 15px 0;
            margin: -40px -40px 20px -40px; 
            text-transform: uppercase;
            letter-spacing: 5px;
        }

        .item-title {
            font-size: 2.2rem;
            color: #333;
            margin: 0 0 15px 0;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .image-container {
            width: 100%;
            flex-grow: 1; 
            max-height: 400px; 
            background: #f0f0f0;
            border: 5px solid #333;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .item-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .details-box {
            text-align: left;
            margin-bottom: 20px;
            padding: 15px;
            border: 2px dashed #999;
            background: #fafafa;
        }

        .detail-row {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: #444;
        }

        .detail-row strong {
            color: #000;
            display: inline-block;
            width: 160px;
        }

        .contact-footer {
            border-top: 4px solid #333;
            padding-top: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .contact-info h2 {
            margin: 0;
            font-size: 1.6rem;
            color: #c0392b;
        }

        .contact-info p {
            margin: 5px 0 0 0;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #2980b9;
            color: white;
            padding: 15px 30px;
            font-size: 1.2rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            transition: transform 0.2s;
            z-index: 999;
        }
        .print-btn:hover { transform: scale(1.05); }

        @media print {
            @page {
                size: A4;
                margin: 0; 
            }

            body, html {
                margin: 0;
                padding: 0;
                background: white;
                height: 100%;
                width: 100%;
            }

            .poster-sheet {
                width: 100%;
                height: 100%; 
                margin: 0;
                box-shadow: none;
                border: none;
                page-break-inside: avoid; 
            }

            .print-btn {
                display: none !important;
            }
        }
    </style>

</head>
<body>

    <div class="poster-sheet">
        
        <div class="header-banner">MISSING</div>

        <h1 class="item-title"><?php echo htmlspecialchars($item['title']); ?></h1>

        <div class="image-container">
            <?php if (!empty($item['image_path'])): ?>
                <img src="../uploads/<?php echo htmlspecialchars($item['image_path']); ?>" class="item-image" alt="Lost Item">
            <?php else: ?>
                <div style="font-size: 2rem; color: #888;">No Photo Available</div>
            <?php endif; ?>
        </div>

        <div class="details-box">
            <div class="detail-row">
                <strong><i class="fas fa-map-marker-alt"></i> Last Seen:</strong> 
                <?php echo htmlspecialchars($item['location']); ?>
            </div>
            <div class="detail-row">
                <strong><i class="far fa-calendar-alt"></i> Date Lost:</strong> 
                <?php echo date('F d, Y', strtotime($item['lost_date'])); // 'date_found' stores 'date_lost' for lost items ?>
            </div>
            <div class="detail-row">
                <strong><i class="fas fa-info-circle"></i> Description:</strong><br>
                <span style="font-size: 1.2rem; display: block; margin-top: 10px; line-height: 1.5;">
                    <?php echo htmlspecialchars($item['description']); ?>
                </span>
            </div>
        </div>

        <div class="contact-footer">
            <div class="contact-info" style="text-align: left;">
                <h2>HAVE YOU SEEN THIS?</h2>
                <p>Please Contact: <?php echo htmlspecialchars($item['full_name']); ?></p>
                
                <?php if (!empty($item['phone_number'])): ?>
                    <p style="font-size: 2rem; margin-top: 10px;">
                        <i class="fas fa-phone-square"></i> <?php echo htmlspecialchars($item['phone_number']); ?>
                    </p>
                <?php else: ?>
                    <p style="margin-top: 10px;">Email: <?php echo htmlspecialchars($item['email']); ?></p>
                <?php endif; ?>
            </div>

            <div style="text-align: center;">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo urlencode($qr_data); ?>" 
                     style="border: 2px solid #333; padding: 5px;">
                <p style="font-size: 0.8rem; margin-top: 5px; font-weight: bold;">SCAN TO REPORT</p>
            </div>
        </div>

    </div>

    <button class="print-btn" onclick="window.print()">
        <i class="fas fa-print"></i> Download / Print PDF
    </button>

</body>
</html>