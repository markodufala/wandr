<?php
// Start the session
session_start();

// Function to find a user's index by username or email
function findUser($data, $usernameOrEmail) {
    foreach ($data as $key => $user) {
        if ($user['usernameOrEmail'] === $usernameOrEmail) {
            return $key;
        }
    }
    return null; // User not found
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted data
    $newName = htmlspecialchars($_POST["newName"]);

    // Read existing users from the JSON file
    $jsonData = file_get_contents('users.json');
    $existingUsers = json_decode($jsonData, true);

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

        // Display a success message
        header("Location: profile.php");
        echo "Username changed successfully!";
    } else {
        // Display an error message
        header("Location: profile.php");
        echo "Failed to change the username. User not found.";
    }
} else {
    // If someone tries to access this file without submitting the form, redirect them
    header("Location: index.php");
    exit();
}
?>
