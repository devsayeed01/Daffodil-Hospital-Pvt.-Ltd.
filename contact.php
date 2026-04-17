<?php include('db_config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us | Daffodil Hospital</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="contact-page-body">

<div class="contact-container">
    <h2 class="contact-title">Contact Us</h2>
    <p class="contact-subtitle">We are here to help you 24/7. Reach out to us anytime.</p>

    <?php
    $info = mysqli_query($conn, "SELECT * FROM hospital_info LIMIT 1");
    $data = mysqli_fetch_assoc($info);
    ?>

    <div class="contact-wrapper">
        <div class="contact-card animate-left">
            <div class="info-item">
                <span class="icon">📍</span>
                <div>
                    <strong>Address</strong>
                    <p><?php echo $data['address']; ?></p>
                </div>
            </div>
            <div class="info-item">
                <span class="icon">📞</span>
                <div>
                    <strong>Hotline</strong>
                    <p>056-000-098</p>
                </div>
            </div>
            <div class="info-item">
                <span class="icon">📧</span>
                <div>
                    <strong>Email</strong>
                    <p>info@daffodilhospital.com</p>
                </div>
            </div>
            <div class="info-item">
                <span class="icon">⏰</span>
                <div>
                    <strong>Emergency</strong>
                    <p>Open 24 Hours</p>
                </div>
            </div>
        </div>

        <div class="map-container animate-right">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3648.455430856983!2d90.3182583!3d23.8734629!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b8adb8ad7097%3A0xd2113bf481358c2!2sDaffodil%20International%20University!5e0!3m2!1sen!2sbd!4v1710000000000!5m2!1sen!2sbd" 
                width="100%" 
                height="400" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
            </iframe>
        </div>
    </div>
</div>

</body>
</html>