<?php
/**
 * User Registration script.
 *
 * This script handles user registration, including form processing, input validation,
 * and saving user data to a JSON file. It also performs file upload and sets session variables.
 *
 * PHP version 7.0 and above
 *
 * @category Registration
 * @package  RegistrationScript
 */

/**
 * Start the session to enable session variables.
 */
session_start();

/**
 * Function to generate a unique ID.
 *
 * @return string The generated unique ID.
 */
function generateUniqueID() {
    return uniqid(); // You may use a more secure method for generating unique IDs
}

/**
 * Include the file containing the checkUsernameOrEmail function.
 */
include 'check_username.php';

/**
 * Array to store registration errors.
 *
 * @var array
 */
$errors = [];

/**
 * Set display errors for debugging.
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * Check if the request method is POST.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /**
     * Sanitize and retrieve the username or email from the form.
     */
    $usernameOrEmail = trim($_POST["usernameOrEmail"]);

    /**
     * Sanitize and retrieve the password from the form.
     */
    $password = $_POST["password"];

    /**
     * Sanitize and retrieve the repeated password from the form.
     */
    $passwordRepeat = $_POST["passwordRepeat"];

    /**
     * Check if the username or email already exists.
     */
    if (checkUsernameOrEmail($usernameOrEmail)) {
        $errors['usernameOrEmail'] = "Užívateľské meno už existuje";
    }

    /**
     * Validate the name length.
     */
    if (strlen($usernameOrEmail) < 3) {
        $errors['usernameOrEmail'] = "Meno musí mať aspoň 3 znaky";
    }

    /**
     * Validate the password length.
     */
    if (strlen($password) < 8) {
        $errors['password'] = "Heslo musí mať aspoň 8 znakov";
    }

    /**
     * Check if passwords match.
     */
    if ($password != $passwordRepeat) {
        $errors['passwordRepeat'] = "Heslá sa nezhodujú.";
    }

    /**
     * Check if a file was uploaded.
     */
    if ($_FILES['profileImage']['error'] !== UPLOAD_ERR_OK) {
        // Handle the upload error
        $errors['profileImage'] = "Nenahrali ste súbor. Kód chyby" . $_FILES['profileImage']['error'];
    } else {
        // Handle uploaded image
        $targetDir = "avatars/"; // Specify the directory where you want to store the images
        $targetFile = $targetDir . time() . '_' . basename($_FILES["profileImage"]["name"]);

        if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, you can save the file path in the database if needed
            $profileImagePath = $targetFile;
        } else {
            // Error uploading file
            $errors['profileImage'] = "Error s nahrávaním obrázka.";
        }
    }

    /**
     * If there are no errors, perform registration logic.
     */
    if (empty($errors)) {
        /**
         * Generate a unique ID.
         */
        $uniqueID = generateUniqueID();

        /**
         * Hash the password.
         */
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        /**
         * Create user array.
         */
        $user = [
            'id' => $uniqueID,
            'usernameOrEmail' => $_POST["usernameOrEmail"],
            'password' => $hashedPassword,
            'profileImagePath' => $profileImagePath, // Add the profile image path
        ];

        /**
         * Read existing users from the JSON file.
         */
        $existingUsers = [];
        if (file_exists('users.json')) {
            $existingUsers = json_decode(file_get_contents('users.json'), true);
        }

        /**
         * Add the new user to the array.
         */
        $existingUsers[] = $user;

        /**
         * Write the updated users array back to the JSON file.
         */
        file_put_contents('users.json', json_encode($existingUsers, JSON_PRETTY_PRINT));

        /**
         * Set session variables.
         */
        $_SESSION['usernameOrEmail'] = $usernameOrEmail;
        $_SESSION['loggedIn'] = true;
        $_SESSION['profileImagePath'] = $profileImagePath; // Add this line

        /**
         * Redirect to the main page.
         */
        header("Location: index.php");
        exit(); // Make sure to exit to prevent further execution
    } else {
        /**
         * Set session variables for errors and input values.
         */
        $_SESSION['errors'] = $errors;
        $_SESSION['usernameOrEmail'] = $usernameOrEmail; // Set usernameOrEmail even in case of errors

        /**
         * Redirect back to register.php.
         */
        header("Location: register.php");
        exit();
    }
}
?>

<!-- Set the maximum file size in bytes -->
<!-- <input type="hidden" name="MAX_FILE_SIZE" value="5000000"> -->
