<?php
/**
 * User password change script.
 *
 * This script handles the change of a user's password, verifying the current password,
 * validating the new password, and updating the password in the user data stored in a JSON file.
 *
 *
 * @category Authentication
 * @package  PasswordChange
 */

/**
 * Start the session to enable session variables.
 */
session_start();

/**
 * Function to find a user's index in the array by username or email.
 *
 * @param array $data             The array containing user data.
 * @param string $usernameOrEmail The username or email to search for.
 *
 * @return int|null The index of the user in the array, or null if not found.
 */
function findUser($data, $usernameOrEmail)
{
    foreach ($data as $key => $user) {
        if ($user->usernameOrEmail === $usernameOrEmail) {
            return $key;
        }
    }
    return null;
}

/**
 * Retrieve user data from a JSON file.
 */
$jsonData = file_get_contents('users.json');
$users = json_decode($jsonData);

/**
 * Get the index of the currently logged-in user.
 */
$usernameOrEmailToFind = $_SESSION['usernameOrEmail'];
$userIndex = findUser($users, $usernameOrEmailToFind);

/**
 * Process the password change when the form is submitted via POST.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /**
     * Retrieve the submitted data.
     */
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    $confirmNewPassword = $_POST["confirmNewPassword"];

    /**
     * Validate password length.
     */
    if (strlen($newPassword) < 8) {
        $_SESSION['passwordChangeError'] = "Heslo musí mať aspoň 8 znakov.";
        header("Location: profile.php");
        exit();
    }

    /**
     * Check if passwords match.
     */
    if ($newPassword != $confirmNewPassword) {
        $_SESSION['passwordChangeError'] = "Hesla sa nezhodujú.";
        header("Location: profile.php");
        exit();
    }

    /**
     * Verify the current password.
     */
    if (password_verify($currentPassword, $users[$userIndex]->password)) {
        /**
         * Hash the new password and update user data.
         */
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $users[$userIndex]->password = $hashedNewPassword;

        /**
         * Encode the updated data back to JSON format.
         */
        $updatedJsonData = json_encode($users, JSON_PRETTY_PRINT);

        /**
         * Write the updated JSON data back to the file.
         */
        file_put_contents('users.json', $updatedJsonData);

        /**
         * Redirect to the profile page with a success message.
         */
        header("Location: profile.php");
        exit();
    } else {
        /**
         * Incorrect current password.
         */
        $_SESSION['passwordChangeError'] = "Nesprávne akutálne heso.";
        header("Location: profile.php");
        exit();
    }
} else {
    /**
     * Redirect to the index page if the form is not submitted via POST.
     */
    header("Location: index.php");
    exit();
}
?>
