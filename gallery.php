<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glorious Gallery | School Moments</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #0f0c29; background: linear-gradient(to right, #24243e, #302b63, #0f0c29); color: white; overflow-x: hidden; }

        /* --- Navigation Bar --- */
        .nav-bar {
            background: rgba(0, 0, 0, 0.6);
            padding: 15px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,215,0,0.3);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 20px;
            background: #1a237e;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
            transition: 0.3s ease;
            border: 1px solid #ffd700;
        }
        .btn-back:hover { background: #ffd700; color: #1a237e; transform: translateX(-5px); }
        
        .btn-admin {
            background: rgba(255, 215, 0, 0.1);
            color: #ffd700;
            border: 1px dashed #ffd700;
        }
        .btn-admin:hover {
            background: #ffd700;
            color: #1a237e;
            transform: translateY(-2px);
        }

        header { text-align: center; padding: 50px 20px; }
        header h1 { font-size: 2.5rem; color: #ffd700; text-transform: uppercase; letter-spacing: 2px; text-shadow: 2px 2px 10px rgba(0,0,0,0.5); }

        /* --- Modern Upload Form --- */
        .upload-container {
            text-align: center; 
            margin: 20px 8%; 
            padding: 30px; 
            background: rgba(255,255,255,0.05); 
            border-radius: 15px; 
            border: 1px dashed #ffd700;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }
        .upload-form {
            display: flex; 
            flex-wrap: wrap; 
            justify-content: center; 
            gap: 15px; 
            align-items: center;
        }
        .input-title {
            padding: 12px 20px; 
            width: 300px; 
            border-radius: 30px; 
            border: 1px solid #ffd700; 
            background: rgba(0,0,0,0.4); 
            color: white;
            outline: none;
            transition: 0.3s;
        }
        .input-title:focus {
            box-shadow: 0 0 10px rgba(255,215,0,0.5);
        }
        .input-file {
            padding: 10px 15px; 
            background: rgba(0,0,0,0.4); 
            border: 1px solid #ffd700; 
            border-radius: 30px; 
            color: white; 
            font-size: 13px;
            outline: none;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-submit {
            background: #ffd700; 
            color: #1a237e; 
            cursor: pointer; 
            margin: 0;
            border: 1px solid #ffd700;
            font-weight: bold;
        }
        .btn-submit:disabled {
            background: #aaaaaa;
            border-color: #aaaaaa;
            color: #666666;
            cursor: not-allowed;
        }

        /* --- Gallery Grid --- */
        .gallery-container { 
            padding: 20px 8%; 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); 
            gap: 25px; 
            perspective: 1000px; 
        }

        .gallery-item {
            position: relative;
            height: 280px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            animation: cardEntrance 0.7s ease-out backwards;
            border: 2px solid rgba(255,255,255,0.1);
        }

        @keyframes cardEntrance {
            from { opacity: 0; transform: scale(0.8) translateY(50px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; cursor: pointer; }
        .gallery-item:hover img { transform: scale(1.1); filter: grayscale(40%); }

        .overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(26, 35, 126, 0.7);
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            opacity: 0; transition: 0.4s; pointer-events: none;
        }
        .gallery-item:hover .overlay { opacity: 1; }
        .overlay i { font-size: 2.5rem; color: #ffd700; transform: translateY(20px); transition: 0.4s; }
        .gallery-item:hover .overlay i { transform: translateY(0); }
        .overlay h3 { margin-top: 15px; font-size: 1.2rem; letter-spacing: 1px; padding: 0 10px; text-align: center; }

        /* --- Lightbox Modal --- */
        #lightbox {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.9);
            display: none; justify-content: center; align-items: center;
            z-index: 2000; flex-direction: column;
        }
        #lightbox img { max-width: 90%; max-height: 80%; border-radius: 10px; border: 3px solid #ffd700; animation: zoom 0.3s ease; }
        @keyframes zoom { from { transform: scale(0.5); } to { transform: scale(1); } }
        #lightbox h2 { margin-top: 15px; color: #ffd700; text-transform: uppercase; }
        .close { position: absolute; top: 20px; right: 30px; font-size: 40px; color: white; cursor: pointer; }

        /* --- Footer Styles --- */
        .main-footer { 
            background: #0f1442; 
            color: #e0e0e0; 
            padding: 60px 8% 30px 8%; 
            border-top: 5px solid #ffd700;
            font-size: 14px; 
            text-align: center; 
            margin-top: 50px;
        }
        .footer-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
            gap: 40px; 
            margin-bottom: 40px; 
        }
        .footer-col h3 { 
            color: #ffffff; 
            font-size: 18px; 
            font-weight: 600; 
            margin-bottom: 20px; 
            position: relative; 
            padding-bottom: 8px; 
            text-transform: uppercase; 
            letter-spacing: 0.5px; 
        }
        .footer-col h3::after { 
            content: ''; 
            position: absolute; 
            left: 50%; 
            bottom: 0; 
            transform: translateX(-50%);
            width: 40px; 
            height: 3px; 
            background: #ffd700; 
            border-radius: 2px; 
        }
        .footer-col p { line-height: 1.8; color: #b0b5d6; margin-bottom: 12px; }
        .footer-col ul { list-style: none; padding: 0; margin: 0; }
        .footer-col ul li { margin-bottom: 12px; }
        .footer-col ul li a { color: #b0b5d6; text-decoration: none; transition: 0.3s ease; display: inline-block; }
        .footer-col ul li a:hover { color: #ffd700; transform: translateY(-3px); }
        .footer-col ul li a i { color: #ffd700; margin-right: 6px; width: 15px; text-align: center; }
        .footer-bottom { border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 30px; text-align: center; }
        .footer-bottom p { color: #8a90b6; font-size: 13px; }
        
        .dev-wrapper { 
            margin-top: 15px; background: rgba(0, 0, 0, 0.2); padding: 10px; 
            border-radius: 8px; display: inline-block; border: 1px solid rgba(255,255,255,0.05); 
        }
        .dev-name {
            font-size: 18px; font-weight: 600; text-decoration: none; display: inline-block;
            background: linear-gradient(90deg, #ffd700, #ffffff, #ffd700); background-size: 200% auto;
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; animation: shine 3s linear infinite;
        }
        @keyframes shine { to { background-position: center; } }

        /* --- Social Floating Elements --- */
        .social-float { position: fixed; right: 25px; bottom: 30px; display: flex; flex-direction: column; gap: 15px; z-index: 2000; }
        .social-btn { 
            width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; 
            color: white; border-radius: 18px; text-decoration: none; font-size: 24px; 
            background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.3); transition: 0.4s; 
        }
        .insta:hover { background: #bc1888; transform: scale(1.2); }
        .yt:hover { background: #FF0000; transform: scale(1.2); }
        .fb:hover { background: #1877F2; transform: scale(1.2); }
        .wa:hover { background: #25D366; transform: scale(1.2); }

        @media (max-width: 768px) {
            .main-footer { padding: 40px 5% 20px 5%; }
            .footer-grid { gap: 30px; }
        }
    </style>
</head>
<body>

<nav class="nav-bar">
    <a href="index.html" class="btn-back">
        <i class="fas fa-arrow-left"></i> Back to Home
    </a>
    <a href="admin.php" target="_blank" class="btn-back btn-admin">
        <i class="fas fa-user-shield"></i> Admin Desk
    </a>
</nav>

<header>
    <h1>Glorious Photo Gallery</h1>
    <p>Capturing the essence of excellence</p>
</header>

<div class="upload-container">
    <h3 style="color: #ffd700; margin-bottom: 5px;">Share Your School Moments</h3>
    <p style="font-size: 13px; color: #b0b5d6; margin-bottom: 20px;">Teachers and Students can submit new photos here (Requires Admin Approval).</p>
    
    <form id="ajaxUploadForm" enctype="multipart/form-data" class="upload-form">
        <input type="text" id="photoTitle" name="title" placeholder="Enter Photo Title (e.g., Sports Day)" required class="input-title">
        <input type="file" id="photoFile" name="photo" accept="image/*" required class="input-file">
        <button type="submit" id="submitBtn" class="btn-back btn-submit"><i class="fas fa-paper-plane"></i> Submit Post</button>
    </form>
</div>

<div class="gallery-container">
    
    <?php
    // --- HOSTINGER LIVE DATABASE ENGINE CONNECTION ---
    $conn = new mysqli("localhost", "u237914560_rio_admin", "Arjun@9341344821", "u237914560_rio_admin");
    
    if (!$conn->connect_error) {
        // Pulls only the approved photographs
        $result = $conn->query("SELECT * FROM school_gallery WHERE status='approved' ORDER BY id DESC");
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                ?>
                <div class="gallery-item">
                    <button onclick="checkPinAndDelete(<?php echo $row['id']; ?>)" style="position: absolute; top: 10px; right: 10px; background: rgba(255,0,0,0.9); color: white; padding: 6px 12px; border-radius: 6px; border: 1px solid white; font-size: 12px; font-weight: bold; cursor: pointer; z-index: 10;">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                    
                    <div onclick="viewPhoto(this)" style="width: 100%; height: 100%;">
                        <img src="<?php echo $row['image_path']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="overlay">
                            <i class="fas fa-expand"></i>
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        $conn->close();
    }
    ?>

    <div class="gallery-item" onclick="viewPhoto(this)">
        <img src="https://www.gloriouspublicschool.com/gallery/building.png" alt="Building">
        <div class="overlay"><i class="fas fa-expand"></i><h3>School Building</h3></div>
    </div>
    <div class="gallery-item" onclick="viewPhoto(this)">
        <img src="https://www.gloriouspublicschool.com/gallery/office.png" alt="Office">
        <div class="overlay"><i class="fas fa-expand"></i><h3>Office</h3></div>
    </div>
    <div class="gallery-item" onclick="viewPhoto(this)">
        <img src="https://www.gloriouspublicschool.com/gallery/smartclass1.png" alt="Class">
        <div class="overlay"><i class="fas fa-expand"></i><h3>Smart Classroom</h3></div>
    </div>
    <div class="gallery-item" onclick="viewPhoto(this)">
        <img src="https://www.gloriouspublicschool.com/gallery/smartclass2.png" alt="Lab">
        <div class="overlay"><i class="fas fa-expand"></i><h3>Classroom</h3></div>
    </div>
    <div class="gallery-item" onclick="viewPhoto(this)">
        <img src="https://www.gloriouspublicschool.com/gallery/2ndsmartclass.png" alt="Science">
        <div class="overlay"><i class="fas fa-expand"></i><h3>Second Smart Class</h3></div>
    </div>
    <div class="gallery-item" onclick="viewPhoto(this)">
        <img src="https://www.gloriouspublicschool.com/gallery/corridor.png" alt="Library">
        <div class="overlay"><i class="fas fa-expand"></i><h3>Corridor</h3></div>
    </div>
    <div class="gallery-item" onclick="viewPhoto(this)">
        <img src="https://www.gloriouspublicschool.com/gallery/boys.jpeg" alt="Sports">
        <div class="overlay"><i class="fas fa-expand"></i><h3>Boys Hostel</h3></div>
    </div>
    <div class="gallery-item" onclick="viewPhoto(this)">
        <img src="https://www.gloriouspublicschool.com/gallery/gloriousstudent.png" alt="Event">
        <div class="overlay"><i class="fas fa-expand"></i><h3>Students</h3></div>
    </div>
    <div class="gallery-item" onclick="viewPhoto(this)">
        <img src="https://www.gloriouspublicschool.com/gallery/hostel.jpg" alt="Event">
        <div class="overlay"><i class="fas fa-expand"></i><h3>Girls Hostel</h3></div>
    </div>
    <div class="gallery-item" onclick="viewPhoto(this)">
        <img src="https://www.gloriouspublicschool.com/gallery/award.png" alt="Event">
        <div class="overlay"><i class="fas fa-expand"></i><h3>Award</h3></div>
    </div>
</div>

<div id="lightbox">
    <span class="close" onclick="closePhoto()">&times;</span>
    <img id="fullImg">
    <h2 id="caption"></h2>
</div>

<div class="social-float">
    <a href="https://wa.link/48bjbp" class="social-btn wa"><i class="fab fa-whatsapp"></i></a>
    <a href="https://www.facebook.com/share/1CGbYGJvvP/" class="social-btn fb"><i class="fab fa-facebook-f"></i></a>
    <a href="https://youtube.com/@gps-maheshra" class="social-btn yt"><i class="fab fa-youtube"></i></a>
    <a href="https://www.instagram.com/gpsmaheshra" class="social-btn insta"><i class="fab fa-instagram"></i></a>
</div>

<footer class="main-footer">
    <div class="footer-grid">
        <div class="footer-col">
            <h3>Useful Links</h3>
            <ul>
                <li><a href="index.html"><i class="fas fa-chevron-right"></i> Home</a></li>
                <li><a href="about.html"><i class="fas fa-chevron-right"></i> About Us</a></li>
                <li><a href="academic.html"><i class="fas fa-chevron-right"></i> Academics</a></li>
                <li><a href="admission.html"><i class="fas fa-chevron-right"></i> Admissions</a></li>
                <li><a href="fa1.html"><i class="fas fa-chevron-right"></i> Examination Results</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h3>Quick Desk</h3>
            <ul>
                <li><a href="fee.html"><i class="fas fa-chevron-right"></i> Pay Online Fee</a></li>
                <li><a href="infrastructure.html" target="_blank"><i class="fas fa-chevron-right"></i> Infrastructure</a></li>
                <li><a href="gallery.php"><i class="fas fa-chevron-right"></i> School Gallery</a></li>
                <li><a href="contact.html"><i class="fas fa-chevron-right"></i> Contact Us</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h3>Contact Info</h3>
            <p><i class="fas fa-map-marker-alt" style="color: #ffd700; margin-right: 6px;"></i> Maheshra, Hazaribag, Jharkhand, 825313</p>
            <p><i class="fas fa-phone-alt" style="color: #ffd700; margin-right: 6px;"></i> <a href="tel:+919430708913" style="color: inherit; text-decoration: none;">+91 94307 08913</a></p>
            <p><i class="fas fa-clock" style="color: #ffd700; margin-right: 6px;"></i> Mon - Sun: 7:00 AM - 5:00 PM</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2026 Glorious Public School, Hazaribag. All Rights Reserved.</p>
        <div class="dev-wrapper">
            <p style="font-size: 12px; color: #a4a9cc; margin-bottom: 4px;">Managed & Contact for Web Development</p>
            <a href="https://arjun-hzb.github.io/arjun-hzb/" target="_blank" class="dev-name">Developed by Arjun</a>
        </div>
    </div>
</footer>

<script>
    function viewPhoto(element) {
        const src = element.querySelector('img').src;
        const title = element.querySelector('h3').innerText;
        document.getElementById('fullImg').src = src;
        document.getElementById('caption').innerText = title;
        document.getElementById('lightbox').style.display = 'flex';
    }
    
    function closePhoto() {
        document.getElementById('lightbox').style.display = 'none';
    }
    
    window.onclick = function(event) {
        if (event.target == document.getElementById('lightbox')) {
            closePhoto();
        }
    }

    // Client-side Security Validation Trigger
    function checkPinAndDelete(photoId) {
        let userPin = prompt("Security Authentication Required! Enter the 4-digit master PIN to delete:");
        if (userPin === null || userPin === "") return;
        
        // Locked with secure credential operational pin (4821)
        if (userPin === "4821") {
            window.location.href = "delete.php?id=" + photoId + "&pin=" + userPin;
        } else {
            alert("Unauthorized Access! Incorrect Security PIN.");
        }
    }

    // --- ASYNC HIGH-PERFORMANCE AJAX UPLOAD GATEWAY ---
    document.getElementById('ajaxUploadForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Inhibits archaic browser page reloads
        
        const submitBtn = document.getElementById('submitBtn');
        const formData = new FormData(this);
        
        // Mutating UI properties to loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Uploading...`;
        
        fetch('upload.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Re-enabling submit system controls
            submitBtn.disabled = false;
            submitBtn.innerHTML = `<i class="fas fa-paper-plane"></i> Submit Post`;
            
            if(data.status === 'success') {
                alert(data.message);
                document.getElementById('ajaxUploadForm').reset(); // Flushes input data caches
            } else {
                alert("Upload failed: " + data.message);
            }
        })
        .catch(error => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = `<i class="fas fa-paper-plane"></i> Submit Post`;
            alert("An operational pipeline error occurred. Please try again.");
            console.error(error);
        });
    });
</script>

</body>
</html>
