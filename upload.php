<?php
// Hostinger Live Database Configuration Settings
header('Content-Type: application/json'); // Enforces programmatic responses

$host = "localhost";
$user = "u237914560_rio_admin"; 
$pass = "Arjun@9341344821";
$dbname = "u237914560_rio_admin";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) { 
    echo json_encode(["status" => "error", "message" => "Database connection breakdown."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photo'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $target_dir = "uploads/"; 
    
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_name = time() . '_' . basename($_FILES["photo"]["name"]);
    $target_file = $target_dir . $file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_types = array("jpg", "jpeg", "png", "gif", "webp");
    
    if (in_array($imageFileType, $allowed_types)) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            
            // Re-enforcing security verification. Status defaults to 'pending'
            $sql = "INSERT INTO school_gallery (title, image_path, status) VALUES ('$title', '$target_file', 'pending')";
            
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["status" => "success", "message" => "Photo submitted successfully! It will be live after Admin approval."]);
            } else { 
                echo json_encode(["status" => "error", "message" => "Database write error execution."]);
            }
        } else { 
            echo json_encode(["status" => "error", "message" => "Failed to write photo object to file storage."]);
        }
    } else { 
        echo json_encode(["status" => "error", "message" => "File extension not allowed. Use JPG, PNG, or WEBP."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request tracking protocol."]);
}
$conn->close();
?>
