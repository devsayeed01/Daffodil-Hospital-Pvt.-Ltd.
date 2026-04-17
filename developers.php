<?php include('db_config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Developers | Daffodil Hospital</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dev-page-body">
    <div class="dev-container">
        <h1 class="dev-title">The Creative Minds</h1>
        <p class="dev-subtitle">Meet the team behind Daffodil Hospital Pvt. Limited</p>
        
        <div class="dev-grid">
            <?php 
            // YOUR TEAM DATA
            $developers = [
                ['name' => 'Md Syduzzaman Chowdhury', 'role' => 'Project Lead & Developer', 'img' => "dev1.png"],
                ['name' => 'Tanjida Akter Asa', 'role' => 'DBMS Admin', 'img' => 'dev2.png'],
                ['name' => 'Sudipta Saha', 'role' => 'UI/UX Designer', 'img' => 'dev3.png'],
                ['name' => 'Shabrina Mostarim Chandni', 'role' => 'ERD & Schema Designer', 'img' => 'dev4.png'],
                ['name' => 'Md Rokibul Islam', 'role' => 'System Analyst', 'img' => 'dev5.png'],
            ];

            foreach($developers as $index => $dev): 
            ?>
            <div class="dev-card animate-card" style="animation-delay: <?php echo $index * 0.2; ?>s;">
                <div class="img-frame">
                    <?php 
                        // Check if the image file exists in your htdocs/daffodil_hospital folder
                        if (file_exists($dev['img'])) {
                            $image_src = $dev['img'];
                        } else {
                            // If file is missing, show a beautiful placeholder with their initials
                            $image_src = "https://ui-avatars.com/api/?name=" . urlencode($dev['name']) . "&background=random&color=fff&size=150";
                        }
                    ?>
                    <img src="<?php echo $image_src; ?>" alt="<?php echo $dev['name']; ?>" class="circle-img">
                </div>
                <h3><?php echo $dev['name']; ?></h3>
                <span class="role-badge"><?php echo $dev['role']; ?></span>
                
                <div class="dev-socials">
                    <!-- <button class="social-btn">View Profile</button> -->
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>