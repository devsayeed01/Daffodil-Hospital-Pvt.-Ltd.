<?php
include('db_config.php');
session_start();

// Security: Check if doctor is logged in via their doc_id
if (!isset($_SESSION['doc_id'])) {
    header("Location: login.php");
    exit();
}

$current_doc_id = $_SESSION['doc_id'];

// Fetch Doctor's Name for the welcome message
$doc_res = mysqli_query($conn, "SELECT name FROM doctors WHERE doc_id = '$current_doc_id'");
$doc_data = mysqli_fetch_assoc($doc_res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor Dashboard | Daffodil Hospital</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome, Dr. <?php echo $doc_data['name']; ?></h1>
            <p>Daffodil Hospital Pvt. Limited | Medical Portal</p>
            <a href="logout.php" class="btn-del">Logout</a>
        </header>

        <section class="appointments-list">
            <h2>Your Appointed Patients</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Phone Number</th>
                        <th>Appointment Date/Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // JOIN query to get patient info from the appointments table
                    $query = "SELECT p.name, p.phone, a.app_date 
                              FROM appointments a
                              JOIN patients p ON a.patient_id = p.id
                              JOIN doctors d ON a.doc_id = d.id
                              WHERE d.doc_id = '$current_doc_id'
                              ORDER BY a.app_date ASC";
                    
                    $result = mysqli_query($conn, $query);
                    
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row['name']}</td>
                                    <td>{$row['phone']}</td>
                                    <td>{$row['app_date']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No appointments found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>