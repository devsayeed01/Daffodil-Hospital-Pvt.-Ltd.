<?php include('db_config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Ambulance Service | Daffodil Hospital</title>
</head>
<body class="ambulance-body">
    <div class="ambulance-container">
        <div class="emergency-header">
            <h2 class="pulse-text">🚑 24/7 Emergency Ambulance Service</h2>
            <p>Immediate response across Daffodil Smart City and Savar area.</p>
        </div>

        <div class="ambulance-grid">
            <?php
            $query = "SELECT * FROM ambulance";
            $result = mysqli_query($conn, $query);
            $count = 0;
            while($row = mysqli_fetch_assoc($result)) {
                $count++;
                // Adding a delay based on the card count for staggered animation
                echo "<div class='ambulance-card' style='animation-delay: " . ($count * 0.2) . "s;'>
                        <div class='ambulance-icon'>🚨</div>
                        <h3>{$row['driver_name']}</h3>
                        <div class='info'>
                            <p><strong>Phone:</strong> {$row['phone']}</p>
                            <p><strong>Type:</strong> <span class='type-tag'>{$row['ambulance_type']}</span></p>
                        </div>
                        <a href='tel:{$row['phone']}' class='call-btn'>Call Now</a>
                      </div>";
            }
            ?>
        </div>
    </div>
</body>
</html>