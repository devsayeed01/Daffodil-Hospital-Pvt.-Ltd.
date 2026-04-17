<?php
$conn = mysqli_connect("localhost:5222", "root", "", "daffodil_db");
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
?>