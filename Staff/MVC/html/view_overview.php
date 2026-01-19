<?php
$items_custody = $conn->query("SELECT COUNT(*) as c FROM items WHERE status='custody'")->fetch_assoc()['c'];
$items_returned = $conn->query("SELECT COUNT(*) as c FROM items WHERE status='claimed'")->fetch_assoc()['c'];
$items_pending = $conn->query("SELECT COUNT(*) as c FROM items WHERE status='found'")->fetch_assoc()['c'];

//CHART DATA Most Common Categories
$cat_query = $conn->query("SELECT category, COUNT(*) as count FROM items GROUP BY category");
$cat_labels = [];
$cat_data = [];
while($row = $cat_query->fetch_assoc()) {
    $cat_labels[] = $row['category'];
    $cat_data[] = $row['count'];
}

//  CHART DATA: High-Risk Locations
$loc_query = $conn->query("SELECT location, COUNT(*) as count FROM items WHERE status='lost' GROUP BY location ORDER BY count DESC LIMIT 5");
$loc_labels = [];
$loc_data = [];
while($row = $loc_query->fetch_assoc()) {
    $loc_labels[] = $row['location'];
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
        <h3 class="section-header"><i class="fas fa-chart-pie"></i> Lost Item Categories</h3>
        <canvas id="categoryChart"></canvas>
    </div>

    <div class="card-box">
        <h3 class="section-header"><i class="fas fa-map-marker-alt"></i> Frequent Loss Locations</h3>
        <canvas id="locationChart"></canvas>
    </div>
</div>

<script>
    //Category Pie Chart
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($cat_labels); ?>,
            datasets: [{
                data: <?php echo json_encode($cat_data); ?>,
                backgroundColor: ['#3498db', '#e74c3c', '#f1c40f', '#2ecc71', '#9b59b6', '#34495e']
            }]
        },
        options: { responsive: true }
    });

    // Location Bar Chart
    new Chart(document.getElementById('locationChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($loc_labels); ?>,
            datasets: [{
                label: 'Number of Lost Reports',
                data: <?php echo json_encode($loc_data); ?>,
                backgroundColor: '#e74c3c'
            }]
        },
        options: { 
            responsive: true,
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
</script>