<?php
include('db_config.php');
session_start();

// Redirect if not logged in
if(!isset($_SESSION['patient_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

$status = "processing"; 
$message = "";

// CATCHING THE ID: We use $_GET['doc_id'] because your link uses ?doc_id=
$doc_id = isset($_GET['doc_id']) ? $_GET['doc_id'] : null;

if ($doc_id && !empty($doc_id)) {
    $doc_id = mysqli_real_escape_string($conn, $doc_id);
    $patient_id = $_SESSION['patient_id'];
    $date = date('Y-m-d'); // Today's date

    // INSERT QUERY
    $sql = "INSERT INTO appointments (patient_id, doc_id, app_date, status) 
            VALUES ('$patient_id', '$doc_id', '$date', 'Pending')";
    
    if(mysqli_query($conn, $sql)) {
        $status = "success";
    } else {
        $status = "error";
        $message = "Database Error: " . mysqli_error($conn);
    }
} else {
    $status = "error";
    $message = "Error: The system did not receive a valid Doctor ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Booking Status | Daffodil Hospital</title>
</head>
<body class="process-body">
    <div class="loader-container">
        <div class="booking-card animate-pop">
            
            <?php if($status == "success"): ?>
                <div class="icon-circle success-bg">✔️</div>
                <h2>Success!</h2>
                <p>Your appointment has been requested.</p>
                <button onclick="window.location.href='patient_dash.php'" class="btn-primary">View Dashboard</button>

            <?php elseif($status == "error"): ?>
                <div class="icon-circle error-bg">❌</div>
                <h2>Booking Failed</h2>
                <p><?php echo $message; ?></p>
                <button onclick="window.location.href='doctors.php'" class="btn-primary" style="background: #e74c3c;">Go Back</button>

            <?php else: ?>
                <div class="pulse-loader">🏥</div>
                <h2>Processing...</h2>
                <p>Connecting you with our specialists.</p>
            <?php endif; ?>

        </div>
    </div>
</body>
</html>