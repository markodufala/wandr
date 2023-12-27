<?php
session_start();

if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
    $usernameOrEmail = $_SESSION['usernameOrEmail'];
    $name = isset($_SESSION['name']) ? $_SESSION['name'] : 'N/A';
    //$uploadFile = isset($_SESSION['uploadFile']) ? $_SESSION['uploadFile'] : ''; // Add this line
    //$profileImagePath = isset($_SESSION['uploadFile']) ? $_SESSION['uploadFile'] : ''; // Update this line
    // echo $profileImagePath;

    $profileImagePath = $_SESSION['profileImagePath'];
    // echo $usernameOrEmail;
    // echo $profileImagePath;
    #echo $profileImagePath;

    // Store password change error if it exists
    $passwordChangeError = isset($_SESSION['passwordChangeError']) ? $_SESSION['passwordChangeError'] : '';

    // Clear the error after storing it
    unset($_SESSION['passwordChangeError']);

    // Process any form submissions for changing password or name here if needed
} else {
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
        <h1>Welcome, <?php echo $usernameOrEmail; ?>!</h1>

            
        <img id="profilePic" src="<?php echo $profileImagePath; ?>" alt="Profile Image">

        <!-- Display password change error if it exists -->
        <?php if (!empty($passwordChangeError)) : ?>
            <p class="error"><?php echo $passwordChangeError; ?></p>
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
