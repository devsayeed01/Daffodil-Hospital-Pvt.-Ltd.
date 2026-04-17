<?php include('db_config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pathology Lab | Daffodil Hospital</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="pathology-body">
    <div class="bg-pulse"></div>

    <div class="pathology-container animate-fade-in">
        <header class="pathology-header">
            <div class="lab-icon">🔬</div>
            <h2>Pathology Department</h2>
            <p>Precise Diagnostics. Faster Results. Better Care.</p>
        </header>

        <div class="test-menu-card">
            <h3>Available Diagnostic Services</h3>
            <div class="table-responsive">
                <table class="styled-path-table">
                    <thead>
                        <tr>
                            <th>Test Name</th>
                            <th>Category</th>
                            <th>Price (BDT)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT test_name, category, price, 
                                  (SELECT AVG(price) FROM pathology) as avg_p 
                                  FROM pathology";
                        $result = mysqli_query($conn, $query);
                        
                        while($row = mysqli_fetch_assoc($result)) {
                            $is_premium = ($row['price'] > $row['avg_p']);
                            $status = $is_premium ? " <span class='premium-tag'>Premium</span>" : "";
                            $row_class = $is_premium ? "row-premium" : "";

                            echo "<tr class='$row_class'>
                                    <td>
                                        <div class='test-info'>
                                            <span class='bullet'></span>
                                            {$row['test_name']} $status
                                        </div>
                                    </td>
                                    <td><span class='cat-badge'>{$row['category']}</span></td>
                                    <td class='price-text'>৳{$row['price']}</td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>