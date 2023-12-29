<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the ID from the URL
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    // Validate and sanitize the ID (you might want to implement more robust validation)
    $id = preg_replace('/[^a-zA-Z0-9\-]/', '', $id);

    if (empty($id)) {
        die("Invalid ID");
    }

    // Get the name from the session
    $name = isset($_SESSION['usernameOrEmail']) ? $_SESSION['usernameOrEmail'] : '';

    // Validate and sanitize the name (adjust as needed)
    $name = htmlspecialchars($name);

    // Get the comment from the form
    $commentText = isset($_POST["comment"]) ? $_POST["comment"] : '';

    // Validate and sanitize the comment (adjust as needed)
    $commentText = htmlspecialchars($commentText);

    // Set the time zone to Prague
    date_default_timezone_set('Europe/Prague');

    // Load existing comments from JSON file based on the ID
    $filename = "comments/$id.json";
    
    if (!file_exists($filename)) {
        // Create an empty JSON file if it doesn't exist
        file_put_contents($filename, json_encode(["comments" => []]));
    }

    $comments = file_get_contents($filename);
    $comments = json_decode($comments, true);

    // Add new comment
    $newComment = array(
        "name" => $name,
        "comment" => $commentText,
        "timestamp" => (new DateTime())->format("d F Y H:i:s")
    );

    $comments["comments/"][] = $newComment;

    // Save updated comments to JSON file
    file_put_contents($filename, json_encode($comments));

    // Redirect back to the comment form
    header("Location: hrebienok.php?id=$id");
    exit();
}
?>
