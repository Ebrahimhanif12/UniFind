<?php
session_start();
include '../../../Student/MVC/db/db_conn.php';

// Security: Owner Only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access Denied");
}


$db_host = 'localhost';
$db_user = 'root'; 
$db_pass = '';    
$db_name = 'unifind_db'; 

$tables = [];
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_row()) {
    $tables[] = $row[0];
}

$sqlScript = "";
foreach ($tables as $table) {
    $result = $conn->query("SHOW CREATE TABLE $table");
    $row = $result->fetch_row();
    $sqlScript .= "\n\n" . $row[1] . ";\n\n";
    
    $result = $conn->query("SELECT * FROM $table");
    $columnCount = $result->field_count;
    
    for ($i = 0; $i < $columnCount; $i++) {
        while ($row = $result->fetch_row()) {
            $sqlScript .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j++) {
                $row[$j] = $row[$j];
                
                if (isset($row[$j])) {
                    $sqlScript .= '"' . $conn->real_escape_string($row[$j]) . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
    }
    $sqlScript .= "\n"; 
}

$admin_id = $_SESSION['user_id'];
$conn->query("INSERT INTO admin_logs (admin_id, action_type, description) VALUES ('$admin_id', 'DB_BACKUP', 'Downloaded full database backup')");

// Download the SQL file
$backup_file_name = $db_name . '_backup_' . date("Y-m-d_H-i-s") . '.sql';
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"".$backup_file_name."\""); 
echo $sqlScript;
exit;
?>