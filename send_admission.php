<?php
// Headers set karein taaki AJAX ko JSON format mein response mile
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // HTML form se sahi data collect karna
    $student_name = isset($_POST['student_name']) ? strip_tags(trim($_POST['student_name'])) : '';
    $class        = isset($_POST['class']) ? strip_tags(trim($_POST['class'])) : '';
    $father_name  = isset($_POST['father_name']) ? strip_tags(trim($_POST['father_name'])) : '';
    $father_phone = isset($_POST['father_phone']) ? strip_tags(trim($_POST['father_phone'])) : '';
    $mother_phone = isset($_POST['mother_phone']) ? strip_tags(trim($_POST['mother_phone'])) : 'Not Provided';
    $full_address = isset($_POST['full_address']) ? strip_tags(trim($_POST['full_address'])) : '';
    $hostel_type  = isset($_POST['hostel_type']) ? strip_tags(trim($_POST['hostel_type'])) : '';
    $submission_date = date("Y-m-d H:i:s");

    // ==================== DATA SAVE TO CSV ====================
    $file_name = 'admissions.csv';
    $file_exists = file_exists($file_name);
    $file_handle = fopen($file_name, 'a');
    if ($file_handle) {
        if (!$file_exists) {
            fputcsv($file_handle, ['Date & Time', 'Student Name', 'Class', 'Father Name', 'Father Phone', 'Mother Phone', 'Facility', 'Address']);
        }
        fputcsv($file_handle, [$submission_date, $student_name, $class, $father_name, $father_phone, $mother_phone, $hostel_type, $full_address]);
        fclose($file_handle);
    }

    // ==================== MAIL FUNCTION ====================
    $to = "gloriousgps@gmail.com"; 
    $from = "gpsmaheshra@gloriouspublicschool.com"; 
    $subject = "New Admission Inquiry: $student_name (Class: $class)";

    $message = "
    <html>
    <head>
        <title>New Admission Inquiry</title>
        <style>
            body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; background-color: #f4f6f9; padding: 20px; }
            .container { max-width: 600px; background: #ffffff; margin: 0 auto; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-top: 5px solid #1a237e; }
            .header { background: #1a237e; color: #ffffff; padding: 20px; text-align: center; }
            .header h2 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
            .header p { margin: 5px 0 0 0; color: #ffd700; font-weight: bold; }
            .content { padding: 25px; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            table td { padding: 12px 15px; border-bottom: 1px solid #eeeeee; font-size: 15px; }
            table td strong { color: #1a237e; }
            .footer { background: #f1f3f9; text-align: center; padding: 15px; font-size: 12px; color: #777; border-top: 1px solid #e2e8f0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Glorious Public School</h2>
                <p>New Admission Inquiry</p>
            </div>
            <div class='content'>
                <table>
                    <tr>
                        <td style='width: 40%;'><strong>Student Name:</strong></td>
                        <td>$student_name</td>
                    </tr>
                    <tr>
                        <td><strong>Class Applied:</strong></td>
                        <td>$class</td>
                    </tr>
                    <tr>
                        <td><strong>Father's Name:</strong></td>
                        <td>$father_name</td>
                    </tr>
                    <tr>
                        <td><strong>Father's Mobile:</strong></td>
                        <td><a href='tel:$father_phone'>$father_phone</a></td>
                    </tr>
                    <tr>
                        <td><strong>Mother's Mobile:</strong></td>
                        <td>" . ($mother_phone ? "<a href='tel:$mother_phone'>$mother_phone</a>" : "Not Provided") . "</td>
                    </tr>
                    <tr>
                        <td><strong>Enquiry For:</strong></td>
                        <td><span style='background: #ffd700; color: #1a237e; padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 13px;'>$hostel_type</span></td>
                    </tr>
                    <tr>
                        <td style='vertical-align: top;'><strong>Full Address:</strong></td>
                        <td style='line-height: 1.5;'>$full_address</td>
                    </tr>
                </table>
            </div>
            <div class='footer'>
                <p>This is an automated system generated inquiry form mail from gloriouspublicschool.com</p>
            </div>
        </div>
    </body>
    </html>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: GPS Admission <$from>" . "\r\n";
    $headers .= "Reply-To: $from" . "\r\n";

    // Mail execute aur JSON response
    @mail($to, $subject, $message, $headers);
    
    echo json_encode(["status" => "success", "message" => "Application submitted successfully."]);
    exit;
} else {
    http_response_code(403);
    echo json_encode(["status" => "error", "message" => "Direct access not allowed."]);
    exit;
}
?>
