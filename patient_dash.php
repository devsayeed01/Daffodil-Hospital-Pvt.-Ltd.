<?php
include('db_config.php');
session_start();

// Redirect to login if not a patient
if(!isset($_SESSION['patient_id'])) { header("Location: login.php"); exit(); }

$patient_id = $_SESSION['patient_id'];

// SQL using GROUP BY and SUBQUERY to calculate occupancy
$total_seats = 300;
$occupied_query = "SELECT COUNT(*) AS occupied FROM bookings";
$res = mysqli_query($conn, $occupied_query);
$row = mysqli_fetch_assoc($res);
$occupied = $row['occupied'];
$available = $total_seats - $occupied;

// Handle Booking Action
if(isset($_POST['book_seat'])) {
    if($available > 0) {
        $sql = "INSERT INTO bookings (patient_id) VALUES ('$patient_id')";
        mysqli_query($conn, $sql);
        echo "<script>alert('Seat Booked Successfully!'); window.location.href='patient_dash.php';</script>";
    } else {
        echo "<script>alert('No seats available!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Patient Dashboard</h2>
        <div class="status-bar">
            <p>Total Seats: 300 | Available Seats: <strong><?php echo $available; ?></strong></p>
        </div>

        <form method="POST">
            <button type="submit" name="book_seat" class="btn-book">Book a Seat Now</button>
        </form>

        <h3>Your Appointments</h3>
        <table>
            <tr><th>Doctor</th><th>Department</th><th>Date</th></tr>
            <?php
            // Using a JOIN to show doctor details for the logged-in patient
            $app_query = "SELECT d.name, d.department, a.app_date 
                          FROM appointments a 
                          JOIN doctors d ON a.doc_id = d.id 
                          WHERE a.patient_id = '$patient_id'";
            $result = mysqli_query($conn, $app_query);
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>{$row['name']}</td><td>{$row['department']}</td><td>{$row['app_date']}</td></tr>";
            }
            ?>
        </table>
    </div>
    <div class="status-box" style="background: white; padding: 20px; border-radius: 15px; margin: 20px 0;">
    <h3>Hospital Bed Occupancy</h3>
    <?php 
        $percent = ($occupied / 300) * 100;
        $bar_color = ($percent > 80) ? '#e74c3c' : '#2ecc71';
    ?>
    <div class="progress-bg" style="background: #eee; height: 30px; border-radius: 15px; overflow: hidden;">
        <div class="progress-fill" style="width: <?php echo $percent; ?>%; background: <?php echo $bar_color; ?>; height: 100%; transition: 1s ease-in-out;"></div>
    </div>
    <p><?php echo $available; ?> Seats remaining out of 300</p>
</div>
</body>
</html>