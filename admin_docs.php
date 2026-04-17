<?php
include('db_config.php');
// Adding Doctor
if(isset($_POST['add_doc'])) {
    $name = $_POST['name'];
    $did = $_POST['did'];
    $dept = $_POST['dept'];
    $pass = $_POST['pass'];
    
    $query = "INSERT INTO doctors (doc_id, name, department, password) VALUES ('$did', '$name', '$dept', '$pass')";
    mysqli_query($conn, $query);
}

// Deleting Doctor
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM doctors WHERE id=$id");
}
?>

<div class="admin-container">
    <h2>Manage Doctors</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Doctor Name" required>
        <input type="text" name="did" placeholder="ID (e.g. DOC101)" required>
        <input type="text" name="dept" placeholder="Department" required>
        <input type="password" name="pass" placeholder="Initial Password" required>
        <button type="submit" name="add_doc">Add Doctor</button>
    </form>

    <table>
        <?php
        $res = mysqli_query($conn, "SELECT * FROM doctors");
        while($row = mysqli_fetch_assoc($res)) {
            echo "<tr>
                <td>{$row['name']}</td>
                <td><a href='admin_docs.php?delete={$row['id']}'>Delete</a></td>
            </tr>";
        }
        ?>
    </table>
</div>