<?php
session_start(); // Start a session

// Function to generate a unique ID
function generateUniqueID() {
    return uniqid(); // You may use a more secure method for generating unique IDs
}


include 'check_username.php';


// PHP code for form processing
$errors = [];


ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = htmlspecialchars(trim($_POST["usernameOrEmail"]));
    $password = htmlspecialchars($_POST["password"]);
    $passwordRepeat = htmlspecialchars($_POST["passwordRepeat"]);


        // Check if the username or email already exists
        if (isUsernameOrEmailExists($usernameOrEmail)) {
            $errors['usernameOrEmail'] = "Uzivatelkse meno už neexistuje";
        }

    // Validate name length
    if (strlen($usernameOrEmail) < 3) {
        $errors['usernameOrEmail'] = "Meno musí mať aspoň 3 znaky";
    }

    // Validate password length
    if (strlen($password) < 8) {
        $errors['password'] = "Heslo musí mať aspoň 8 znakov";
    }

    // Check if passwords match
    if ($password != $passwordRepeat) {
        $errors['passwordRepeat'] = "Hesla sa nezhodujú.";
    }

    if ($_FILES['profileImage']['error'] !== UPLOAD_ERR_OK) {
        // Handle the upload error
        $errors['profileImage'] = "Nenahrali ste súbor. Kód chyby" . $_FILES['profileImage']['error'];
        //$errors['profileImage'] = "Nenahrali ste súbor.";
    } else {
        // Handle uploaded image
        $targetDir = "avatars/"; // Specify the directory where you want to store the images
        $targetFile = $targetDir . time() . '_' . basename($_FILES["profileImage"]["name"]);

        if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, you can save the file path in the database if needed
            $profileImagePath = $targetFile;
        } else {
            // Error uploading file
            $errors['profileImage'] = "Error s nahravanim obrazka.";
        }
    }

    // If there are no errors, perform registration logic
    if (empty($errors)) {
        // Generate unique ID
        $uniqueID = generateUniqueID();

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Create user array
        $user = [
            'id' => $uniqueID,
            'usernameOrEmail' => $usernameOrEmail,
            'password' => $hashedPassword,
            'profileImagePath' => $profileImagePath, // Add the profile image path
        ];

        // Read existing users from the JSON file
        $existingUsers = [];
        if (file_exists('users.json')) {
            $existingUsers = json_decode(file_get_contents('users.json'), true);
        }

        // Add the new user to the array
        $existingUsers[] = $user;

        // Write the updated users array back to the JSON file
        file_put_contents('users.json', json_encode($existingUsers, JSON_PRETTY_PRINT));

        // Set session variables
        $_SESSION['usernameOrEmail'] = $usernameOrEmail;
        $_SESSION['loggedIn'] = true;
        $_SESSION['profileImagePath'] = $profileImagePath; // Add this line

        // Redirect to the main page
        header("Location: index.php");
        exit(); // Make sure to exit to prevent further execution
    } else {
        $_SESSION['errors'] = $errors;
        $_SESSION['usernameOrEmail'] = $usernameOrEmail; // Set usernameOrEmail even in case of errors
        // Redirect back to register.php
        header("Location: register.php");
        exit();
    }
}
?>


<input type="hidden" name="MAX_FILE_SIZE" value="5000000"> <!-- Set the maximum file size in bytes -->

