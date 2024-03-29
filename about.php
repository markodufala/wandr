<?php


 session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wandr</title>
    <link rel="stylesheet" href="css/about.css">
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
    <div class="bg"></div>


    <p>Vitaj na stránke Wandr! sme váš sprievodca svetom dobrodružstva a
    objavovania. Srdcom našej vášne sú turistické traily, ktoré spájajú ľudí s
    prírodou a kultúrou našej krásnej planéty.</p>

    <p>Wandr vznikol s jednoduchým cieľom: inšpirovať ľudí k objavovaniu krásy
    Slovenska okolo nás prostredníctvom pútavých a dobre premyslených
    turistických trás. Nech už ste dobrodruh z vášne alebo oddaný turista, naša
    stránka vám ponúka prehľad a informácie o rôznych trailoch na celom svete. </p>
    <br>


    <p>
        Naša tímová vášeň pre cestovanie a dobrodružstvo nás motivuje k tomu,
        aby sme vytvárali obsah, ktorý vás inšpiruje, usmernuje a pomáha vám pri
        plánovaní vašich vlastných dobrodružstiev. Wandr nie je len o trasách;
        je to o komunite cestovateľov, ktorí si delia lásku k prírode a túžbu
        objavovať nové miesta.</p> <br>
        
        <p>
        Prispievajte svojimi skúsenosťami, zdieľajte svoje príbehy a nechajte sa
        inšpirovať ďalšími dobrodruhmi. S Wandr neexistuje koniec ciest, len
        nové začiatky objavovania. Vstúpte do našej komunity a spolu s nami
        objavujte nádherný svet turistických trás.</p>


        <footer>
            <img src="inverse_logo.svg" alt="">
          </footer>
    

</body>
</html>