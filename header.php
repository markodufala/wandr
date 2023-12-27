<?php
// Start the session
session_start();
?>

<header>
    <div class="logo">
        <a href="index.php"><img src="Wandr.svg" alt="Logo"></a>
    </div>
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About us</a>
        <a href="trails.php">Trails</a>
    </nav>
    
    <?php
        // Check if the user is logged in
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
            // If logged in, display the "Profile" button
            echo '<a href="profile.php"><button class="profile-btn">Profile</button></a>';
        } else {
            // If not logged in, display the "Login" button
            echo '<a href="login.php"><button class="login-btn">Login</button></a>';
        }
    ?>
</header>
