<?php
/**
 * Ensure that a session is started if not already active.
 */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Function to check if a given username or email exists in the user data stored in 'users.json'.
 *
 * @param string $usernameOrEmail The username or email to check for existence.
 *
 * @return bool True if the username or email exists, false otherwise.
 */
function checkUsernameOrEmail($usernameOrEmail) {
    if (file_exists('users.json')) {
        $existingUsers = json_decode(file_get_contents('users.json'), true);
        
        foreach ($existingUsers as $user) {
            if ($user['usernameOrEmail'] === $usernameOrEmail) {
                return true; // Username or email exists
            }
        }
    }

    return false; // Username or email does not exist
}

/**
 * Check if the request method is POST and if the 'usernameOrEmail' parameter is set in the POST data.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usernameOrEmail"])) {
    /**
     * Retrieve and sanitize the 'usernameOrEmail' parameter from the POST data.
     */
    $usernameOrEmailToCheck = trim($_POST["usernameOrEmail"]);
    
    /**
     * Check if the username or email exists.
     */
    $usernameOrEmailExists = checkUsernameOrEmail($usernameOrEmailToCheck);
    
    /**
     * Send the response to the AJAX request.
     */
    $usernameOrEmailExists ? "1" : "0";
}
?>
