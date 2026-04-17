<?php include('db_config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <title>Specialist Doctors | Daffodil Hospital</title>
</head>
<body class="doctors-bg">
    <div class="container-glass">
        <h2 class="section-title">Our Specialist Doctors</h2>
        <p class="section-subtitle">Meet our world-class medical experts dedicated to your health.</p>
        
        <div class="table-responsive">
            <table class="animated-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Schedule</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM doctors WHERE id IN (SELECT id FROM doctors)";
                    $result = mysqli_query($conn, $query);
                    $delay = 0; // For staggered animation
                    while($row = mysqli_fetch_assoc($result)) {
                        $delay += 0.1;
                        echo "<tr style='animation-delay: {$delay}s'>
                            <td class='doc-name'><strong>Dr. {$row['name']}</strong></td>
                            <td><span class='dept-badge'>{$row['department']}</span></td>
                            <td><i class='far fa-clock'></i> {$row['schedule']}</td>
                            <td><a href='appointment.php?doc_id={$row['id']}' class='btn-book-now'>Take Appointment</a></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>