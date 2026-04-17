<?php

include('db_config.php');



if(isset($_POST['signup'])) {

    $name = $_POST['name'];

    $phone = $_POST['phone'];

    $email = $_POST['email'];

    $pass = $_POST['password'];



    // Check if phone already exists

    $check = mysqli_query($conn, "SELECT * FROM patients WHERE phone = '$phone'");

    if(mysqli_num_rows($check) > 0) {

        echo "<script>alert('Phone number already registered!');</script>";

    } else {

        // Advanced Requirement: Transaction

        mysqli_begin_transaction($conn);

        try {

            $query = "INSERT INTO patients (name, phone, email, password) VALUES ('$name', '$phone', '$email', '$pass')";

            mysqli_query($conn, $query);

            mysqli_commit($conn);

            echo "<script>alert('Registration Successful! Please Login.'); window.location.href='login.php';</script>";

        } catch (Exception $e) {

            mysqli_rollback($conn);

            echo "Error: " . $e->getMessage();

        }

    }

}

?>



<!DOCTYPE html>

<html>

<head>

    <link rel="stylesheet" href="style.css">

    <title>Patient Registration | Daffodil Hospital</title>

</head>

<body>

    <div class="login-box">

        <h2>Patient Sign Up</h2>

        <form method="POST">

            <input type="text" name="name" placeholder="Full Name" required>

            <input type="text" name="phone" placeholder="Phone Number" required>

            <input type="email" name="email" placeholder="Email ID" required>

            <input type="password" name="password" placeholder="Create Password" required>

            <button type="submit" name="signup" class="btn">Register</button>

        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>

    </div>

</body>

</html>