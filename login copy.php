<?php
session_start(); // Start a session

$profileImagePath = null;

// Function to check if the user exists in the JSON file
function userExists($usernameOrEmail, $password) {
    $users = json_decode(file_get_contents('users.json'), true);

    foreach ($users as $user) {
        if ($user['usernameOrEmail'] == $usernameOrEmail) {
            // User found, now check the password
            if (password_verify($password, $user['password'])) {
                $profileImagePath = $user['profileImagePath'];
                return ['exists' => true, 'profileImagePath' => $profileImagePath];
            } else {
                // Password is incorrect
                return ['exists' => true, 'profileImagePath' => null, 'incorrectPassword' => true];
            }
        }
    }

    // User not found
    return ['exists' => false, 'profileImagePath' => null];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = htmlspecialchars(trim($_POST["usernameOrEmail"]));
    $password = htmlspecialchars($_POST["password"]);
   
    $result = userExists($usernameOrEmail, $password);

    // Check if the user exists
    if ($result['exists']) {
        // Check if the password is incorrect
        if ($result['incorrectPassword']) {
            $loginError = "Nesprávne heslo";
        } else {
            // Set session variables
            $_SESSION['usernameOrEmail'] = $usernameOrEmail;
            $_SESSION['loggedIn'] = true;
            $_SESSION['profileImagePath'] = $result['profileImagePath'];

            // Redirect to the main page
            header("Location: index.php");
            exit(); // Make sure to exit to prevent further execution
        }
    } else {
        // User does not exist
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
    <title>Wand Login</title>
    <link rel="stylesheet" href="css/login.css">
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
        <?php if (isset($loginError)) echo "<p style='color: red;'>{$loginError}</p>"; ?>
        <form method="post" action="login.php">
            <input type="text" name="usernameOrEmail" placeholder="Username or Email" value="<?php echo isset($usernameOrEmail) ? $usernameOrEmail : ''; ?>" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Prihlásiť sa</button>
        </form>
    </div>
</body>
</html>
