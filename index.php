<?php

/**
 * Include the header.php file to incorporate header content in the HTML document.
 *
 * @file
 * @author Marko Dufala
 */

 session_start();


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wandr</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Avenir+Next:wght@400;700&display=swap">

</head>
<body>

<header>
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
            echo '<a href="profile.php" class="login-btn">Profil</a>';
        } else {
            // If not logged in, display the "Login" button
            echo '<a href="login.php" class="login-btn">Prihláste sa</a>';
        }
    ?>
</header>
    <div class="bg">

        <p id="hero_text">Nie všetci ktorí wandrujú
            sú stratení
        </p>

        <p id="hero">
            Pre prezeranie trailov sa prihláste, a prezerajte si trasy vo vašom okolí.
            Budte ten ktorý wandruje.
        </p>

        <!-- <button href="login.php" class="login-btn">
            Prihláste sa
        </button> -->
    </div>



    <footer>
        <img src="inverse_logo.svg" alt="">
      </footer>


</body>
</html>