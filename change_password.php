<?php
session_start();

function findUser($data, $usernameOrEmail) {
    foreach ($data as $key => $user) {
        if ($user->usernameOrEmail === $usernameOrEmail) {
            return $key;
        }
    }
    return null;
}

$jsonData = file_get_contents('users.json');
$users = json_decode($jsonData);

$usernameOrEmailToFind = $_SESSION['usernameOrEmail'];
$userIndex = findUser($users, $usernameOrEmailToFind);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = htmlspecialchars($_POST["currentPassword"]);
    $newPassword = htmlspecialchars($_POST["newPassword"]);
    $confirmNewPassword = htmlspecialchars($_POST["confirmNewPassword"]);

    // Validate password length
    if (strlen($newPassword) < 8) {
        $_SESSION['passwordChangeError'] = "Password must be at least 8 characters long.";
        header("Location: profile.php");
        exit();
    }

    // Check if passwords match
    if ($newPassword != $confirmNewPassword) {
        $_SESSION['passwordChangeError'] = "Passwords do not match.";
        header("Location: profile.php");
        exit();
    }

    if (password_verify($currentPassword, $users[$userIndex]->password)) {
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $users[$userIndex]->password = $hashedNewPassword;
        $updatedJsonData = json_encode($users, JSON_PRETTY_PRINT);
        file_put_contents('users.json', $updatedJsonData);

        // Display a success message
        header("Location: profile.php");
        exit();
    } else {
        // Incorrect current password
        $_SESSION['passwordChangeError'] = "Incorrect current password.";
        header("Location: profile.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
