<?php
include('db_config.php');
session_start();

if ($_POST['action'] == 'add_doctor') {
    $name = $_POST['name'];
    $did = $_POST['doc_id'];
    $dept = $_POST['dept'];
    $phone = $_POST['phone'];
    $pass = $_POST['pass'];
    
    $sql = "INSERT INTO doctors (doc_id, name, phone, department, password) VALUES ('$did', '$name', '$phone', '$dept', '$pass')";
    mysqli_query($conn, $sql);
}

if ($_POST['action'] == 'add_pathology') {
    $name = $_POST['t_name'];
    $cat = $_POST['t_cat'];
    $price = $_POST['t_price'];
    
    $sql = "INSERT INTO pathology (test_name, category, price) VALUES ('$name', '$cat', '$price')";
    mysqli_query($conn, $sql);
}

if ($_POST['action'] == 'add_ambulance') {
    $dname = $_POST['d_name'];
    $phone = $_POST['phone'];
    $type = $_POST['type'];
    
    $sql = "INSERT INTO ambulance (driver_name, phone, ambulance_type) VALUES ('$dname', '$phone', '$type')";
    
    // Catch the Trigger's 'SIGNAL' message
    if(mysqli_query($conn, $sql)) {
        header("Location: admin_dash.php");
    } else {
        $trigger_error = mysqli_error($conn);
        header("Location: admin_dash.php?error=" . urlencode($trigger_error));
    }
    exit();
}

// Add this to your existing admin_actions.php
if (isset($_POST['action']) && $_POST['action'] == 'edit_doctor') {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $dept = mysqli_real_escape_string($conn, $_POST['dept']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    
    $sql = "UPDATE doctors SET name='$name', department='$dept', phone='$phone' WHERE id=$id";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: admin_dash.php?success=Doctor updated");
    } else {
        header("Location: admin_dash.php?error=Update failed");
    }
    exit();
}
header("Location: admin_dash.php");
?>