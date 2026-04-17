<?php
include('db_config.php');
// Start Transaction
mysqli_begin_transaction($conn);

try {
    $sql = "INSERT INTO doctors (doc_id, name, department) VALUES ('D001', 'Dr. Abrar', 'Cardiology')";
    mysqli_query($conn, $sql);
    
    mysqli_commit($conn);
    echo "Doctor added successfully!";
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "Error occurred.";
}
?>