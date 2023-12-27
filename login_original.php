<?php
session_start(); // Start a session

$profileImagePath = null;

// Function to check if the user exists in the JSON file
function userExists($usernameOrEmail, $password) {
    $users = json_decode(file_get_contents('users.json'), true);

    foreach ($users as $user) {
        if ($user['usernameOrEmail'] == $usernameOrEmail && password_verify($password, $user['password'])) {
            $profileImagePath = $user['profileImagePath'];
            return ['exists' => true, 'profileImagePath' => $profileImagePath];
        }
    }

    return ['exists' => false, 'profileImagePath' => null];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = htmlspecialchars(trim($_POST["usernameOrEmail"]));
    $password = htmlspecialchars($_POST["password"]);
   
    $result = userExists($usernameOrEmail, $password);

    // Check if the user exists
    if ($result['exists']) {
        // Set session variables
        $_SESSION['usernameOrEmail'] = $usernameOrEmail;
        $_SESSION['loggedIn'] = true;
        $_SESSION['profileImagePath'] = $result['profileImagePath'];

        // Redirect to the main page
        header("Location: index.php");
        exit(); // Make sure to exit to prevent further execution
    } else {
        $loginError = "Invalid username/email or password. Please check your credentials or register.";
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
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">
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
            <input type="text" name="usernameOrEmail" placeholder="Uživatelské meno alebo email" required>
            <input type="password" name="password" placeholder="Heslo" required>
            <button type="submit">Prihlásiť sa</button>
        </form>
    </div>
</body>
</html>
