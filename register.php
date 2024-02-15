<?php
/**
 * User Registration Page.
 *
 * This page includes the registration process script and retrieves any errors
 * or previously entered data from the session for displaying on the registration form.
 *
 *
 * @category Registration
 * @package  RegistrationPage
 */

/**
 * Include the user registration process script.
 */
include "register_process.php";

/**
 * Array to store registration errors.
 *
 * @var array
 */
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];

/**
 * Retrieve the previously entered username or email from the session, if available.
 */
$usernameOrEmail = isset($_SESSION['usernameOrEmail']) ? $_SESSION['usernameOrEmail'] : "";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wandr Login</title>
    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">

</head>
<body>

    <div class="colored-half">
        <div class="logo">
            <a href="index.php"><img src="inverse_logo.svg" alt="Logo"></a>
        </div>
        <a href="login.php"><h1 id="login">Login</h1></a>
<a href="register.php"><h1 id="register">Register</h1></a>
    </div>



    <div id="login-form">
    <form method="post" action="register_process.php" enctype="multipart/form-data">

        <label for="usernameOrEmail">Uživatelské meno:</label>
        <input type="text" name="usernameOrEmail" id="usernameOrEmail" placeholder="Uživatelské meno" required
               value="<?php echo htmlspecialchars($usernameOrEmail); ?>">

        <?php if (isset($errors['usernameOrEmail'])) echo "<p class='error-message'>{$errors['usernameOrEmail']}</p>"; ?>

        <p id="usernameOrEmailMessage" class="error-message"></p>

        <label for="password">Heslo:</label>
        <input type="password" name="password" id="password" placeholder="Heslo" required>
        <?php if (isset($errors['password'])) echo "<p class='error-message'>{$errors['password']}</p>"; ?>

        <label for="passwordRepeat">Heslo znovu:</label>
        <input type="password" name="passwordRepeat" id="passwordRepeat" placeholder="Heslo znovu" required>
        <?php if (isset($errors['passwordRepeat'])) echo "<p class='error-message'>{$errors['passwordRepeat']}</p>"; ?>

        <!-- Add the input field for image upload -->
        <label for="profileImage">Profilový obrázok:</label>
        <input type="file" name="profileImage" id="profileImage" accept="image/*">

        <?php if (isset($errors['profileImage'])) echo "<p class='error-message'>{$errors['profileImage']}</p>"; ?>

        <input type="hidden" name="MAX_FILE_SIZE" value="5000000"> <!-- Set the maximum file size in bytes -->

        <p>*Všetky polia sú povinné</p><br>
        <button type="submit">Registrovať sa</button>
    </form>

</div>


<script src="checking_username.js"></script>



    

</body>
</html>
