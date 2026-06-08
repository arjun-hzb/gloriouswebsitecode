<?php
// Hostinger Database Details
$conn = new mysqli("localhost", "u237914560_rio_admin", "Arjun@9341344821", "u237914560_rio_admin");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // 1. Folder se asli file delete karne ke liye path nikalna
    $result = $conn->query("SELECT image_path FROM school_gallery WHERE id = $id");
    if ($row = $result->fetch_assoc()) {
        $file = $row['image_path'];
        if (file_exists($file)) {
            unlink($file); // File folder se delete ho gayi
        }
    }
    
    // 2. Database se entry hatana
    $conn->query("DELETE FROM school_gallery WHERE id = $id");
}

$conn->close();
header("Location: gallery.php");
exit();
?>
