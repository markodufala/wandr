<?php
/**
 * User Profile script.
 *
 * This script checks if a user is logged in, retrieves relevant session data,
 * and handles any form submissions for changing the password or name.
 *
 * PHP version 7.0 and above
 *
 * @category UserProfile
 * @package  UserProfileScript
 */

/**
 * Start the session to enable session variables.
 */
session_start();

/**
 * Check if the user is logged in.
 */
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
    /**
     * Retrieve the user's username or email from the session.
     */
    $usernameOrEmail = $_SESSION['usernameOrEmail'];

    /**
     * Retrieve the user's name from the session or set to 'N/A' if not available.
     */
    $name = isset($_SESSION['name']) ? $_SESSION['name'] : 'N/A';

    /**
     * Retrieve the user's profile image path from the session.
     */
    $profileImagePath = $_SESSION['profileImagePath'];

    /**
     * Store the password change error if it exists.
     */
    $passwordChangeError = isset($_SESSION['passwordChangeError']) ? $_SESSION['passwordChangeError'] : '';

    $nameChangeError =  isset($_SESSION['nameChangeError']) ? $_SESSION['nameChangeError'] : '';

    /**
     * Clear the error after storing it.
     */
    unset($_SESSION['passwordChangeError']);

    /**
     * Process any form submissions for changing the password or name here if needed.
     * (Additional code for processing form submissions can be added here)
     */
} else {
    /**
     * Redirect to the login page if the user is not logged in.
     */
    header("Location: login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/profile.css"> <!-- Add your custom styles for the profile page -->
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">

</head>
<body>
    <div class="logo">
        <a href="index.php"><img src="Wandr.svg" alt="Logo"></a>
    </div>

    <div class="profile-container">
        <h1>Welcome, <?php echo htmlspecialchars($usernameOrEmail); ?>!</h1>

            
        <img id="profilePic" src="<?php echo $profileImagePath; ?>" alt="Profile Image">

        <!-- Display password change error if it exists -->
        <?php if (!empty($passwordChangeError)) : ?>
            <p class="error"><?php echo $passwordChangeError; ?></p>
        <?php endif; ?>


        <?php if (!empty($nameChangeError)) : ?>
            <p class="error"><?php echo $nameChangeError; ?></p>
        <?php endif; ?>


        <!-- Add a form to change the password -->
        <form method="post" action="change_password.php">
            <label for="currentPassword">Current Password:</label>
            <input type="password" id="currentPassword" name="currentPassword" required><br>
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPassword" required><br>
            <label for="confirmNewPassword">Confirm New Password:</label>
            <input type="password" id="confirmNewPassword" name="confirmNewPassword" required><br>
            <button type="submit">Change Password</button>
        </form>

        <!-- Add a form to change the name -->
        <form method="post" action="change_name.php">
            <label for="newName">New Name:</label>
            <input type="text" id="newName" name="newName" required><br>
            <button type="submit">Change Name</button>
        </form>

        <!-- Add a logout button -->
        <form method="post" action="logout.php">
            <button type="submit">Logout</button>
        </form>

        <!-- Add more profile information here as needed -->
    </div>

</body>
</html>
