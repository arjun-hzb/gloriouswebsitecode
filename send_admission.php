<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form data collect karna
    $student_name = $_POST['student_name'];
    $class = $_POST['class'];
    $father_name = $_POST['father_name'];
    $phone = $_POST['phone'];
    $hostel_type = $_POST['hostel_type'];

    // Kisko mail bhejna hai
    $to = "gloriousgps@gmail.com"; 
    
    // Kis mail ID se jayega (Hostinger mail)
    $from = "gpsmaheshra@gloriouspublicschool.com"; 
    
    $subject = "New Admission Inquiry: $student_name";

    // Email content (Message body)
    $message = "
    <html>
    <head>
    <title>New Admission Inquiry</title>
    </head>
    <body>
    <h2>Student Details</h2>
    <table style='width:100%; border:1px solid #ddd;'>
        <tr><td><strong>Student Name:</strong></td><td>$student_name</td></tr>
        <tr><td><strong>Class:</strong></td><td>$class</td></tr>
        <tr><td><strong>Father's Name:</strong></td><td>$father_name</td></tr>
        <tr><td><strong>Phone:</strong></td><td>$phone</td></tr>
        <tr><td><strong>Hostel Required:</strong></td><td>$hostel_type</td></tr>
    </table>
    </body>
    </html>
    ";

    // Headers set karna taki HTML mail jaye
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: GPS Admission <$from>" . "\r\n";
    $headers .= "Reply-To: $from" . "\r\n";

    // Mail send function
    if (mail($to, $subject, $message, $headers)) {
        // Success: User ko wapas form par bhej dega (Success message display hoga)
        echo "<script>window.location.href='index.html?status=success';</script>";
    } else {
        echo "Mail send karne mein error aayi.";
    }
} else {
    echo "Direct access not allowed.";
}
?>
