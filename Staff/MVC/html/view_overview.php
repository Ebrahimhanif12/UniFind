<?php
// 1. TOP CARDS DATA
$items_custody = $conn->query("SELECT COUNT(*) as c FROM items WHERE status='custody'")->fetch_assoc()['c'];
$items_returned = $conn->query("SELECT COUNT(*) as c FROM items WHERE status='claimed'")->fetch_assoc()['c'];
$items_pending = $conn->query("SELECT COUNT(*) as c FROM items WHERE status='found'")->fetch_assoc()['c'];

// 2. PIE CHART: Categories (All Items)
$cat_query = $conn->query("SELECT category, COUNT(*) as count FROM items GROUP BY category");
$cat_labels = [];
$cat_data = [];
while($row = $cat_query->fetch_assoc()) {
    $cat_labels[] = $row['category'];
    $cat_data[] = $row['count'];
}

// 3. BAR CHART: Locations (FIXED)
// Removed "WHERE status='lost'" so it shows ALL activity (Lost + Found + Custody)
// Added "WHERE location != ''" to prevent blank entries
$loc_query = $conn->query("SELECT location, COUNT(*) as count 
                           FROM items 
                           WHERE location != '' 
                           GROUP BY location 
                           ORDER BY count DESC 
                           LIMIT 5");
$loc_labels = [];
$loc_data = [];
while($row = $loc_query->fetch_assoc()) {
    $loc_labels[] = trim($row['location']); 
    $loc_data[] = $row['count'];
}
?>

<div class="stats-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
    
    <div class="card-box" style="border-left: 5px solid #27ae60;">
        <div style="color: #666; font-size: 0.9rem;">Items in Custody</div>
        <div style="font-size: 2rem; font-weight: bold; color: #2c3e50;"><?php echo $items_custody; ?></div>
        <div style="font-size: 0.8rem; color: #27ae60;">Physically in office</div>
    </div>

    <div class="card-box" style="border-left: 5px solid #f39c12;">
        <div style="color: #666; font-size: 0.9rem;">Incoming (Pending)</div>
        <div style="font-size: 2rem; font-weight: bold; color: #2c3e50;"><?php echo $items_pending; ?></div>
        <div style="font-size: 0.8rem; color: #f39c12;">Waiting for drop-off</div>
    </div>

    <div class="card-box" style="border-left: 5px solid #3498db;">
        <div style="color: #666; font-size: 0.9rem;">Successfully Returned</div>
        <div style="font-size: 2rem; font-weight: bold; color: #2c3e50;"><?php echo $items_returned; ?></div>
        <div style="font-size: 0.8rem; color: #3498db;">Total solved cases</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    
    <div class="card-box">
        <h3 class="section-header"><i class="fas fa-chart-pie"></i> Item Categories</h3>
        <div style="height: 300px; display: flex; justify-content: center;">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    <div class="card-box">
        <h3 class="section-header"><i class="fas fa-map-marker-alt"></i> High Lost/Found Locations</h3>
        <div style="height: 300px;">
            <canvas id="locationChart"></canvas>
        </div>
    </div>
</div>

<script>
    // 1. PIE CHART CONFIG
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($cat_labels); ?>,
            datasets: [{
                data: <?php echo json_encode($cat_data); ?>,
                backgroundColor: ['#3498db', '#2ecc71','#9b59b6', '#f1c40f', '#e74c3c', '#34495e'],
                borderWidth: 1
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // 2. BAR CHART CONFIG
    new Chart(document.getElementById('locationChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($loc_labels); ?>,
            datasets: [{
                label: 'Total Reports (Lost & Found)', // Updated Label
                data: <?php echo json_encode($loc_data); ?>,
                backgroundColor: '#e74c3c',
                borderRadius: 4,
                maxBarThickness: 50 // Keeps bars looking nice
            }]
        },
        options: { 
            responsive: true,
            maintainAspectRatio: false,
            scales: { 
                y: { 
                    beginAtZero: true, 
                    ticks: { stepSize: 1, precision: 0 } // Forces whole numbers
                },
                x: {
                    grid: { display: false }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>