<?php
include('db_config.php');
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Handling Deletions
if (isset($_GET['del_type']) && isset($_GET['id'])) {
    $type = $_GET['del_type'];
    $id = $_GET['id'];
    if ($type == 'doctor')
        $query = "DELETE FROM doctors WHERE id = $id";
    if ($type == 'pathology')
        $query = "DELETE FROM pathology WHERE id = $id";
    if ($type == 'ambulance')
        $query = "DELETE FROM ambulance WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: admin_dash.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard | Daffodil Hospital</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Modal Styling for Edit Function */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); backdrop-filter: blur(5px); }
        .modal-content { background-color: white; margin: 10% auto; padding: 30px; border-radius: 15px; width: 400px; box-shadow: 0 5px 30px rgba(0,0,0,0.3); }
        .close { float: right; font-size: 24px; cursor: pointer; color: #666; }
        .status-available { background: #d4edda; color: #155724; }
        .status-busy { background: #f8d7da; color: #721c24; }
        .btn-reset { background: #1e3c72; color: white; padding: 4px 8px; border-radius: 4px; text-decoration: none; font-size: 0.7rem; margin-left: 5px; }
    </style>
</head>

<body class="admin-body">
    <div class="admin-container">
        <header class="admin-header animate-pop">
            <h1>Staff Control Panel</h1>
            <div class="user-badge">
                <span>Logged in as: <strong>Admin</strong></span>
                <a href="logout.php" class="logout-link">Logout</a>
            </div>
        </header>

        <div class="dashboard-grid">
            
            <div class="admin-section animate-slide-in" style="animation-delay: 0.1s; grid-column: span 2;">
                <div class="section-icon">📋</div>
                <h3>Live Appointment Report (Database View)</h3>
                <div class="scroll-table">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Dept</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $view_query = "SELECT * FROM appointment_details ORDER BY app_date DESC";
                            $view_res = mysqli_query($conn, $view_query);
                            if ($view_res && mysqli_num_rows($view_res) > 0) {
                                while ($v_row = mysqli_fetch_assoc($view_res)) {
                                    echo "<tr>
                                        <td>{$v_row['patient_name']}</td>
                                        <td>Dr. {$v_row['doctor_name']}</td>
                                        <td>{$v_row['department']}</td>
                                        <td>{$v_row['app_date']}</td>
                                        <td><span class='badge'>{$v_row['status']}</span></td>
                                      </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No appointments found in view.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="admin-section animate-slide-in" style="animation-delay: 0.2s;">
                <div class="section-icon">👨‍⚕️</div>
                <h3>Manage Specialist Doctors</h3>
                
                <form action="admin_actions.php" method="POST" class="styled-form">
                    <input type="hidden" name="action" value="add_doctor">
                    <input type="text" name="name" placeholder="Doctor Name" required>
                    <input type="text" name="doc_id" placeholder="ID (e.g. D-101)" required>
                    <input type="text" name="dept" placeholder="Department" required>
                    <input type="text" name="phone" placeholder="Phone" required>
                    <input type="password" name="pass" placeholder="Password" required>
                    <button type="submit" class="btn-primary">Add Doctor</button>
                </form>

                <div class="scroll-table" style="margin-top: 20px;">
                    <table class="admin-table">
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $res = mysqli_query($conn, "SELECT * FROM doctors");
                        while ($row = mysqli_fetch_assoc($res)) {
                            $status = isset($row['status']) ? $row['status'] : 'Available';
                            $status_class = ($status == 'Available') ? 'status-available' : 'status-busy';
                            
                            echo "<tr>
                                <td><strong>{$row['name']}</strong></td>
                                <td><span class='badge $status_class'>$status</span></td>
                                <td>
                                    <button class='btn-edit' onclick='openEditModal(" . json_encode($row) . ")' style='background:#f39c12; color:white; border:none; padding:4px 8px; border-radius:4px; cursor:pointer;'>✏️</button>
                                    
                                    <a href='admin_dash.php?del_type=doctor&id={$row['id']}' class='btn-del' onclick='return confirm(\"Delete Dr. {$row['name']}?\")'>🗑️</a>";
                                    
                                    if($status == 'Busy') {
                                        echo "<a href='admin_actions.php?action=reset_status&id={$row['id']}' class='btn-reset'>✅</a>";
                                    }
                            echo "</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div class="admin-section animate-slide-in" style="animation-delay: 0.3s;">
                <div class="section-icon">🔬</div>
                <h3>Pathology & Tests</h3>
                <form action="admin_actions.php" method="POST" class="styled-form">
                    <input type="hidden" name="action" value="add_pathology">
                    <input type="text" name="t_name" placeholder="Test Name" required>
                    <input type="text" name="t_cat" placeholder="Category" required>
                    <input type="number" name="t_price" placeholder="Price" required>
                    <button type="submit" class="btn-primary">Add Test</button>
                </form>
                <div class="scroll-table">
                    <table class="admin-table">
                        <tr><th>Test</th><th>Price</th><th>Action</th></tr>
                        <?php
                        $res = mysqli_query($conn, "SELECT * FROM pathology");
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr><td>{$row['test_name']}</td><td>৳{$row['price']}</td>
                                  <td><a href='admin_dash.php?del_type=pathology&id={$row['id']}' class='btn-del'>Delete</a></td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div class="admin-section animate-slide-in" style="animation-delay: 0.4s;">
                <div class="section-icon">🚑</div>
                <h3>Ambulance Fleet</h3>
                <?php if (isset($_GET['error'])): ?>
                    <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 10px; font-size: 0.85rem;">
                        ⚠️ <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>

                <form action="admin_actions.php" method="POST" class="styled-form">
                    <input type="hidden" name="action" value="add_ambulance">
                    <input type="text" name="d_name" placeholder="Driver Name" required>
                    <input type="text" name="phone" placeholder="Phone Number (Min 10 digits)" required>
                    <input type="text" name="type" placeholder="Ambulance Type" required>
                    <button type="submit" class="btn-primary">Add Ambulance</button>
                </form>

                <div class="scroll-table">
                    <table class="admin-table">
                        <tr><th>Driver</th><th>Phone</th><th>Action</th></tr>
                        <?php
                        $res = mysqli_query($conn, "SELECT * FROM ambulance");
                        while ($row = mysqli_fetch_assoc($res)) {
                            echo "<tr><td>{$row['driver_name']}</td><td>{$row['phone']}</td>
                            <td><a href='admin_dash.php?del_type=ambulance&id={$row['id']}' class='btn-del'>Delete</a></td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div id="editModal" class="modal">
        <div class="modal-content animate-pop">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Edit Doctor Details</h3>
            <form action="admin_actions.php" method="POST" class="styled-form">
                <input type="hidden" name="action" value="edit_doctor">
                <input type="hidden" name="id" id="edit_id">
                <input type="text" name="name" id="edit_name" placeholder="Name" required>
                <input type="text" name="dept" id="edit_dept" placeholder="Department" required>
                <input type="text" name="phone" id="edit_phone" placeholder="Phone" required>
                <button type="submit" class="btn-primary">Save Changes</button>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(doctor) {
            document.getElementById('edit_id').value = doctor.id;
            document.getElementById('edit_name').value = doctor.name;
            document.getElementById('edit_dept').value = doctor.department;
            document.getElementById('edit_phone').value = doctor.phone;
            document.getElementById('editModal').style.display = "block";
        }
        function closeModal() {
            document.getElementById('editModal').style.display = "none";
        }
        // Close modal if user clicks outside of it
        window.onclick = function(event) {
            if (event.target == document.getElementById('editModal')) closeModal();
        }
    </script>
</body>
</html>