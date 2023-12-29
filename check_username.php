<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Function to check if a usernameOrEmail exists in data.json
function isUsernameOrEmailExists($usernameOrEmail) {
    if (file_exists('users.json')) {
        $existingUsers = json_decode(file_get_contents('users.json'), true);
        
        foreach ($existingUsers as $user) {
            if ($user['usernameOrEmail'] === $usernameOrEmail) {
                return true; // UsernameOrEmail exists
            }
        }
    }

    return false; // UsernameOrEmail does not exist
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usernameOrEmail"])) {
    $usernameOrEmailToCheck = htmlspecialchars(trim($_POST["usernameOrEmail"]));
    
    // Check if the usernameOrEmail exists
    $usernameOrEmailExists = isUsernameOrEmailExists($usernameOrEmailToCheck);
    
    // Send the response to the AJAX request
    $usernameOrEmailExists ? "1" : "0";
}
?>
