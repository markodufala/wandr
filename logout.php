<?php
/**
 * Log out script.
 *
 * This script ends the user's session by unsetting all session variables and destroying the session.
 * After the logout, the user is redirected to the index page.
 *
 * PHP version 7.0 and above
 *
 * @category Authentication
 * @package  Logout
 */

/**
 * Start the session to enable session variables.
 */
session_start();

/**
 * Unset all session variables.
 */
$_SESSION = array();

/**
 * Destroy the session.
 */
session_destroy();

/**
 * Redirect to the index page after logout.
 * 
 * @note The 'exit()' function is used to prevent further execution after the header redirection.
 */
header("Location: index.php");
exit();
?>
