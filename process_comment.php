<?php
/**
 * Comment submission script.
 *
 * This script handles the submission of comments, validates input data, and saves comments to a JSON file.
 * It retrieves the user's name from the session, sanitizes input data, sets the time zone to Prague,
 * and redirects back to the comment form after processing.
 *
 *
 * @category Comments
 * @package  CommentSubmission
 */

/**
 * Start the session to enable session variables.
 */
session_start();

/**
 * Check if the request method is POST.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /**
     * Get the ID from the URL.
     */
    $id = isset($_GET['id']) ? $_GET['id'] : '';

    /**
     * Validate and sanitize the ID (more robust validation may be implemented).
     */
    $id = preg_replace('/[^a-zA-Z0-9\-]/', '', $id);

    /**
     * Terminate with an error message if the ID is empty or invalid.
     */
    if (empty($id)) {
        die("Invalid ID");
    }

    /**
     * Get the user's name from the session.
     */
    $name = isset($_SESSION['usernameOrEmail']) ? $_SESSION['usernameOrEmail'] : '';

    /**
     * Validate and sanitize the name (adjust as needed).
     */
    // $name = htmlspecialchars($name);

    /**
     * Get the comment from the form.
     */
    $commentText = isset($_POST["comment"]) ? $_POST["comment"] : '';

    /**
     * Validate and sanitize the comment (adjust as needed).
     */
    // $commentText = htmlspecialchars($commentText);

    /**
     * Set the time zone to Prague.
     */
    date_default_timezone_set('Europe/Prague');

    /**
     * Load existing comments from the JSON file based on the ID.
     */
    $filename = "comments/$id.json";
    
    /**
     * Create an empty JSON file if it doesn't exist.
     */
    if (!file_exists($filename)) {
        file_put_contents($filename, json_encode(["comments" => []]));
    }

    /**
     * Read and decode existing comments from the JSON file.
     */
    $comments = file_get_contents($filename);
    $comments = json_decode($comments, true);

    /**
     * Create a new comment with user's name, comment text, and timestamp.
     */
    $newComment = array(
        "name" => $name,
        "comment" => $commentText,
        "timestamp" => (new DateTime())->format("d F Y H:i:s")
    );

    /**
     * Add the new comment to the existing comments array.
     */
    $comments["comments/"][] = $newComment;

    /**
     * Save updated comments to the JSON file.
     */
    file_put_contents($filename, json_encode($comments));

    /**
     * Redirect back to the comment form with the specified ID.
     */
    header("Location: hrebienok.php?id=$id");
    exit();
}
?>
