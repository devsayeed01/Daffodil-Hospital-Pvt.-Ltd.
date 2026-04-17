<?php
include('db_config.php');
session_start();

$role = $_POST['role'];

if ($role == 'staff') {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    // Hardcoded logic as per your requirement: admin / admindiuhospital
    if($user == 'admin' && $pass == 'admindiuhospital') {
        $_SESSION['admin'] = true;
        header("Location: admin_dash.php");
    } else { echo "Invalid Admin Credentials"; }
}

if ($role == 'patient') {
    $phone = $_POST['phone'];
    $pass = $_POST['password'];
    $sql = "SELECT * FROM patients WHERE phone='$phone' AND password='$pass'";
    $res = mysqli_query($conn, $sql);
    if(mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['patient_id'] = $row['id'];
        header("Location: patient_dash.php");
    } else { echo "Invalid Patient Credentials"; }
}
// Add this inside auth.php
if ($role == 'doctor') {
    $doc_id = $_POST['doc_id'];
    $pass = $_POST['password'];
    
    $sql = "SELECT * FROM doctors WHERE doc_id='$doc_id' AND password='$pass'";
    $res = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['doc_id'] = $row['doc_id']; // Store the custom Doctor ID
        header("Location: doctor_dash.php");
    } else {
        echo "<script>alert('Invalid Doctor ID or Password'); window.location.href='login.php';</script>";
    }
}
?>