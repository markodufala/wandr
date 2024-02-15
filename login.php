<?php
/**
 * Start a session to enable session variables.
 */
session_start();

/**
 * Variable to store the path to the user's profile image.
 *
 * @var string|null $profileImagePath The path to the user's profile image.
 */
$profileImagePath = null;

/**
 * Function to check if a user with the given username or email and password exists in the JSON file.
 *
 * @param string $usernameOrEmail The username or email to check.
 * @param string $password        The password to verify.
 * @param string|null $profileImagePath (output) The path to the user's profile image (modified by reference).
 *
 * @return array An associative array with the following keys:
 *               - 'exists': True if the user exists, false otherwise.
 *               - 'profileImagePath': The path to the user's profile image.
 *               - 'incorrectPassword': True if the provided password is incorrect, false otherwise.
 */
function userExists($usernameOrEmail, $password, &$profileImagePath) {
    $users = json_decode(file_get_contents('users.json'), true);

    foreach ($users as $user) {
        if ($user['usernameOrEmail'] == $usernameOrEmail) {
            // User found, now check the password
            if (password_verify($password, $user['password'])) {
                $profileImagePath = $user['profileImagePath'];
                return ['exists' => true, 'profileImagePath' => $profileImagePath, 'incorrectPassword' => false];
            } else {
                // Password is incorrect
                return ['exists' => true, 'profileImagePath' => null, 'incorrectPassword' => true];
            }
        }
    }

    // User not found
    return ['exists' => false, 'profileImagePath' => null, 'incorrectPassword' => false];
}

/**
 * Check if the request method is POST.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /**
     * Retrieve and sanitize the 'usernameOrEmail' and 'password' parameters from the POST data.
     */
    $usernameOrEmail = trim($_POST["usernameOrEmail"]);
    $password = $_POST["password"];
   
    /**
     * Call the 'userExists' function to check the existence of the user.
     */
    $result = userExists($usernameOrEmail, $password, $profileImagePath);

    /**
     * Check if the user exists.
     */
    if ($result['exists']) {
        /**
         * Check if the password is incorrect.
         */
        if ($result['incorrectPassword']) {
            $loginError = "Nesprávne heslo";
        } else {
            /**
             * Set session variables.
             */
            $_SESSION['usernameOrEmail'] = $usernameOrEmail;
            $_SESSION['loggedIn'] = true;
            $_SESSION['profileImagePath'] = $result['profileImagePath'];

            /**
             * Redirect to the main page.
             */
            header("Location: index.php");
            exit(); // Make sure to exit to prevent further execution
        }
    } else {
        /**
         * User does not exist.
         */
        $loginError = "Užívatel neexistuje, skontrolujte svoje prihlasovacie údaje.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wandr Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">

</head>
<body>
    <div class="colored-half">
        <div class="logo">
            <a href="index.php"><img src="inverse_logo.svg" alt="Logo"></a>
        </div>
        <a href="login.php"><h1 id="login">Login</h1></a>
        <a href="register.php"><h1>Register</h1></a>
    </div>

    <div id="login-form">
    <?php if (isset($loginError)) echo "<p class='error-message'>{$loginError}</p>"; ?>
    
    <form method="post" action="login.php">
        <label for="usernameOrEmail">Užívatelské meno:</label>
        <input type="text" name="usernameOrEmail" id="usernameOrEmail" placeholder="Username or Email" value="<?php echo isset($usernameOrEmail) ? $usernameOrEmail : ''; ?>" required>

        <label for="password">Heslo:</label>
        <input type="password" name="password" id="password" placeholder="Password" required>

        <button type="submit">Prihlásiť sa</button>
    </form>
</div>
</body>
</html>
