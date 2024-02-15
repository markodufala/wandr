<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">



<head>
    <div class="logo">
        <a href="index.php"><img src="Wandr.svg" alt="Logo"></a>
    </div>
    <nav>
        <a href="index.php">Domov</a>
        <a href="about.php">O nás</a>
        <a href="trails.php">Traily</a>
    </nav>
    
    <?php
        // Check if the user is logged in
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
            // If logged in, display the "Profile" button
            echo '<a href="profile.php"><button class="profile-btn">Profil</button></a>';
        } else {
            // If not logged in, display the "Login" button
            echo '<a href="login.php"><button class="login-btn">Prihláste sa</button></a>';
        }
    ?>
</head>

