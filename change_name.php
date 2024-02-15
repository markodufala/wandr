<?php
/**
 * This script handles the updating of a user's username.
 * 
 * It starts a session, retrieves submitted data, and updates the username in both the session
 * and a JSON file containing user information. The user is then redirected to the profile page
 * with success or error messages.
 */

// Start the session to enable session variables
session_start();

/**
 * Function to find a user's index in the array by username or email.
 *
 * @param array $data The array containing user data.
 * @param string $usernameOrEmail The username or email to search for.
 * @return int|null The index of the user in the array, or null if not found.
 */
function findUser($data, $usernameOrEmail) {
    foreach ($data as $key => $user) {
        if ($user['usernameOrEmail'] === $usernameOrEmail) {
            return $key;
        }
    }
    return null; // User not found
}

// Check if the form has been submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted data
    $newName = $_POST["newName"];

    // Read existing users from the JSON file
    $jsonData = file_get_contents('users.json');
    $existingUsers = json_decode($jsonData, true);

    // Check if the new name already exists
    $nameExists = in_array($newName, array_column($existingUsers, 'usernameOrEmail'));

    if (!$nameExists) {
        // Example: Get the index of the user in the array
        $usernameOrEmailToFind = $_SESSION['usernameOrEmail'];
        $userIndex = findUser($existingUsers, $usernameOrEmailToFind);

        // Update the user's name in the session
        $_SESSION['usernameOrEmail'] = $newName;

        // Update the user's name in the array
        if ($userIndex !== null) {
            $existingUsers[$userIndex]['usernameOrEmail'] = $newName;

            // Encode the updated data back to JSON format
            $updatedJsonData = json_encode($existingUsers, JSON_PRETTY_PRINT);

            // Write the updated JSON data back to the file
            file_put_contents('users.json', $updatedJsonData);

            // Redirect to the profile page with a success message
            header("Location: profile.php");
            echo "Username changed successfully!";
        } else {
            // Set session variable for error
            $_SESSION['nameChangeError'] = "Failed to change the username. User not found.";
            
            // Redirect to the profile page with an error message
            header("Location: profile.php");
        }
    } else {
        // Set session variable for error
        $_SESSION['nameChangeError'] = "Užívatelské meno už existuje";
        
        // Redirect to the profile page with an error message
        header("Location: profile.php");
    }
} else {
    // If someone tries to access this file without submitting the form, redirect them
    header("Location: index.php");
    exit();
}
?>
