<?php
/**
 * Start the session to enable session variables.
 */
session_start();

/**
 * Check if the user is logged in. If not, redirect to the login page.
 * 
 * @note This assumes that a session variable 'loggedIn' is set to true upon successful login.
 */
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login.php');
    exit;
}

/**
 * Include the header.php file to incorporate header content in the HTML document.
 * 
 * @file
 */

/**
 * Get the 'id' parameter from the URL.
 * 
 * @var string $id The ID parameter from the URL.
 */
$id = isset($_GET['id']) ? $_GET['id'] : '';

/**
 * Load JSON content from the file.
 * 
 * @var string $jsonFile The path to the JSON file.
 * @var string $jsonContents The content of the JSON file.
 * @var array $allItems An array containing all items parsed from the JSON file.
 */
$jsonFile = 'data.json'; // Replace with the actual path to your JSON file
$jsonContents = file_get_contents($jsonFile);
$allItems = json_decode($jsonContents, true);

/**
 * Find the item with the matching 'id'.
 * 
 * @var array|null $selectedItem The selected item matching the provided 'id'.
 */
$selectedItem = null;
foreach ($allItems as $item) {
    if ($item['id'] === $id) {
        $selectedItem = $item;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">
    <link rel="stylesheet" href="css/hrebienok.css">
    <title><?php echo $selectedItem['heading']; ?></title>
</head>
<body>

    <header>
    <div class="logo">
        <a href="index.php"><img src="Wandr.svg" alt="Logo"></a>
    </div>
    <nav>
        <a href="index.php">Domov</a>
        <a href="about.php">O nás</a>
        <a href="trails.php">Traily</a>
    </nav>
    
    <?php
        // Check if the user is logged in
        if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
            // If logged in, display the "Profile" button
            echo '<a href="profile.php" class="login-btn">Profil</a>';
        } else {
            // If not logged in, display the "Login" button
            echo '<a href="login.php" class="login-btn">Prihláste sa</a>';
        }
    ?>
</header>

    <section id="stats">
    <h1><?php echo $selectedItem['heading']; ?></h1>

    <img class="main-image" src="<?php echo $selectedItem['img1']; ?>" alt="" id="main_img">


    <h2>Náročnosť</h2>

    
    <div><?php echo $selectedItem['Náročnosť']; ?></div>

    <h2>Výhlady</h2>



    <div><?php echo $selectedItem['Výhľady']; ?></div>


    <h2>Dav</h2>

    <div><?php echo $selectedItem['Dávka']; ?></div>


    <h2>Ročné obdobia</h2>
    <div><?php echo $selectedItem['Ročné obdobie']; ?></div>

    </section>

    <img class="gallery-image" src="<?php echo $selectedItem['img2']; ?>" alt="" id="gallery_image">

    <section id="info">
        <h3>Popis túry</h3>
        <?php echo $selectedItem['paragraph1']; ?>
        <br>
        <br>
        <br>
        <br>

        <?php echo $selectedItem['paragraph2']; ?>
    </section>

    <h4><?php echo $selectedItem['Trasa']; ?></h4>

    <table>
        <tr>
            <td>Dĺžka trasy</td>
            <td> <?php echo $selectedItem['dlzka']; ?></td>
        </tr>
        <tr>
            <td>Časová náročnosť</td>
            <td><?php echo $selectedItem['cas']; ?></td>
        </tr>
        <tr>
            <td>Výškové prevýšenie</td>
            <td><?php echo $selectedItem['vyska']; ?></td>
        </tr>
    </table>

    <h3>Komentáre</h3>



<div class="container" id="main">
    <form id="comment-form" action="process_comment.php?id=<?php echo $id; ?>" method="post">

        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" rows="4" required></textarea>

        <input type="submit" value="Submit Comment">
    </form>

</div>


<div class="content-container">

<?php
/**
 * Process comment submission.
 * 
 * This code handles the submission of comments through a form and displays existing comments.
 * The comments are stored in individual JSON files based on the unique ID of the item.
 * 
 * @var string $id The ID of the item for which comments are being processed.
 */
$id = isset($_GET['id']) ? $_GET['id'] : '';

/**
 * Validate and sanitize the ID (you might want to implement more robust validation).
 * 
 * @note You might want to implement additional validation/sanitization based on your requirements.
 */
// $id = preg_replace('/[^a-zA-Z0-9\-]/', '', $id);

if (empty($id)) {
    die("Invalid ID");
}

/**
 * Load comments from the corresponding JSON file based on the item ID.
 * 
 * @var string $filename The path to the comments JSON file.
 */
$filename = "comments/$id.json";

/**
 * Check if the comments file exists.
 */
if (!file_exists($filename)) {
    die("Comments file not found");
}

/**
 * Read the content of the comments file and decode it as JSON.
 * 
 * @var string $comments The JSON-encoded comments.
 */
$comments = file_get_contents($filename);
$comments = json_decode($comments, true);

/**
 * Display comments in reverse order (newest first) or indicate if there are no comments yet.
 */
if (isset($comments['comments/']) && is_array($comments['comments/'])) {
    $commentsArray = $comments['comments/'];
    $commentsArray = array_reverse($commentsArray);
    foreach ($commentsArray as $comment) {
        echo "<p><strong>" . htmlspecialchars($comment['name'], ENT_QUOTES, 'UTF-8') . "</strong> (" . htmlspecialchars($comment['timestamp'], ENT_QUOTES, 'UTF-8') . "): " . htmlspecialchars($comment['comment'], ENT_QUOTES, 'UTF-8') . "</p>";

    }
} else {
    echo "No comments yet.";
}
?>
</div>



</body>
</html>



