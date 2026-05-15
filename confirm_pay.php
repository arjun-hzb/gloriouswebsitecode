<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = htmlspecialchars($_POST['student_name']);
    $class = htmlspecialchars($_POST['student_class']);
    $amount = htmlspecialchars($_POST['amount']);

    // Display a nice success message
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>Submission Successful</title>
        <style>
            body { font-family: 'Poppins', sans-serif; background: #f1f5f9; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
            .card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); text-align: center; }
            h1 { color: #10b981; }
            p { color: #64748b; }
            .back-btn { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #4f46e5; color: white; text-decoration: none; border-radius: 10px; }
        </style>
    </head>
    <body>
        <div class='card'>
            <h1>✅ Submitted Successfully!</h1>
            <p>Verification for <strong>$name</strong> ($class) of <strong>₹$amount</strong> has been received.</p>
            <p>Our staff will verify the screenshot soon.</p>
            <a href='index.html' class='back-btn'>Go Back</a>
        </div>
    </body>
    </html>";
} else {
    header("Location: index.html");
    exit();
}
?>
