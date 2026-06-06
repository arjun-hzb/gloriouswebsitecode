<?php
session_start();
$secret_password = "arjun123"; 
$file_name = 'admissions.csv';

// ==================== ENGINE: ROW DELETE LOGIC ====================
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    if (!isset($_GET['password']) || $_GET['password'] !== $secret_password) {
        die("Access Denied!");
    }

    $target_id = intval($_GET['id']); 
    
    if (file_exists($file_name)) {
        $lines = file($file_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $remaining_rows = [];
        
        foreach ($lines as $index => $line) {
            if ($index === 0) {
                $remaining_rows[] = str_getcsv($line);
                continue;
            }
            if ($index !== $target_id) {
                $remaining_rows[] = str_getcsv($line);
            }
        }
        
        $file_handle = fopen($file_name, 'w');
        if ($file_handle) {
            foreach ($remaining_rows as $row) {
                fputcsv($file_handle, $row);
            }
            fclose($file_handle);
        }
    }
    header("Location: view_admissions.php?password=" . urlencode($secret_password) . "&status=deleted");
    exit;
}

// 
echo "<html><head><title>Admin - Admission Dashboard</title>";
echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'>";
echo "<style>
    body { font-family: 'Segoe UI', Arial, sans-serif; background: #f4f6f9; padding: 30px; margin: 0; }
    h2 { color: #1a237e; text-align: center; margin-bottom: 5px; font-weight:800; }
    .table-container { max-width: 1200px; margin: 0 auto; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow-x: auto; }
    .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px; border-bottom: 2px solid #eee; padding-bottom: 15px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { padding: 14px; border: 1px solid #e2e8f0; text-align: left; font-size: 14px; }
    th { background: #1a237e; color: white; font-weight: 600; text-transform: uppercase; font-size: 13px; }
    tr:nth-child(even) { background: #f8fafc; }
    tr:hover { background: #f1f5f9; }
    .btn-download { display: inline-flex; align-items: center; gap: 8px; background: #25D366; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-weight: bold; transition: 0.3s; }
    .btn-download:hover { background: #128C7E; }
    .btn-delete { background: #dc2626; color: white; padding: 6px 12px; text-decoration: none; border-radius: 6px; font-size: 13px; font-weight: 600; transition: 0.3s; display: inline-flex; align-items: center; gap: 4px; border: none; cursor: pointer; }
    .btn-delete:hover { background: #991b1b; transform: scale(1.03); }
    .alert { background: #d1fae5; color: #065f46; padding: 12px; border-radius: 8px; text-align: center; margin-bottom: 15px; font-weight: 600; border: 1px solid #a7f3d0; font-size: 15px; }
</style></head><body>";

echo "<div class='table-container'>";
echo "<h2>Glorious Public School</h2>";
echo "<p style='text-align:center; color:#666; margin-top:0; margin-bottom:25px;'>Admission Management Dashboard</p>";

// 
if (isset($_GET['status']) && $_GET['status'] == 'deleted') {
    echo "<div class='alert'><i class='fas fa-check-circle'></i> Student record successfully deleted!</div>";
}

echo "<div class='top-bar'>";
// 2. SET EXPLICITLY TO ADMISSION INQUIRIES
echo "<span style='font-size: 18px; font-weight:700; color:#1a237e;'><i class='fas fa-users'></i> Admission Inquiries</span>";
echo "<a href='$file_name' class='btn-download' download><i class='fas fa-file-excel'></i> Export Excel File</a>";
echo "</div>";

if (file_exists($file_name) && filesize($file_name) > 10) {
    $file_handle = fopen($file_name, 'r');
    echo "<table>";
    
    $headers = fgetcsv($file_handle);
    if ($headers) {
        echo "<tr>";
        foreach ($headers as $header) { echo "<th>" . htmlspecialchars($header) . "</th>"; }
        echo "<th style='text-align:center;'>Action</th>";
        echo "</tr>";
    }
    
    $row_index = 1; 
    while (($row = fgetcsv($file_handle)) !== FALSE) {
        if (empty(array_filter($row))) continue; 
        echo "<tr>";
        foreach ($row as $cell) { echo "<td>" . htmlspecialchars($cell) . "</td>"; }
        
        $delete_url = "view_admissions.php?action=delete&id=$row_index&password=" . urlencode($secret_password);
        echo "<td style='text-align:center;'>
                <a href='$delete_url' class='btn-delete' onclick=\"return confirm('Are you sure you want to delete this student record?');\">
                    <i class='fas fa-trash-alt'></i> Delete
                </a>
              </td>";
        echo "</tr>";
        $row_index++;
    }
    echo "</table>";
    fclose($file_handle);
} else {
    echo "<p style='text-align:center; color:#94a3b8; padding: 50px 0; font-size:16px;'><i class='fas fa-folder-open' style='font-size:40px; display:block; margin-bottom:15px; color:#cbd5e1;'></i> No data available at the moment.</p>";
}

echo "</div></body></html>";
?>
