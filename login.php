<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Daffodil Hospital</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page-body">
    <div class="circles">
        <li></li><li></li><li></li><li></li><li></li>
    </div>

    <div class="login-wrapper">
        <div class="login-box glass-effect">
            <div class="login-header">
                <h2>Daffodil Hospital</h2>
                <p>Welcome Back! Please login to continue.</p>
            </div>
            
            <div class="tabs">
                <button class="tab-btn active-tab" onclick="showTab('patient')">Patient</button>
                <button class="tab-btn" onclick="showTab('doctor')">Doctor</button>
                <button class="tab-btn" onclick="showTab('staff')">Staff</button>
            </div>

            <div id="patient" class="form-panel active-panel animate-fade">
                <h3>Patient Portal</h3>
                <form action="auth.php" method="POST">
                    <input type="hidden" name="role" value="patient">
                    <div class="input-group">
                        <input type="text" name="phone" placeholder="Phone Number" required>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn-glow">Login</button>
                    <p class="signup-link">New here? <a href="signup.php">Create Account</a></p>
                </form>
            </div>

            <div id="doctor" class="form-panel animate-fade">
                <h3>Doctor Portal</h3>
                <form action="auth.php" method="POST">
                    <input type="hidden" name="role" value="doctor">
                    <input type="text" name="doc_id" placeholder="Doctor ID" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="btn-glow">Login</button>
                </form>
            </div>

            <div id="staff" class="form-panel animate-fade">
                <h3>Staff Portal</h3>
                <form action="auth.php" method="POST">
                    <input type="hidden" name="role" value="staff">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="btn-glow">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showTab(role) {
            document.querySelectorAll('.form-panel').forEach(p => p.classList.remove('active-panel'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active-tab'));
            const target = document.getElementById(role);
            target.classList.add('active-panel');
            event.currentTarget.classList.add('active-tab');
        }
    </script>
</body>
</html>