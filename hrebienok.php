<?php
session_start();

// Check if the user is not logged in, redirect to login.php
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login.php');
    exit;

}
// Rest of your trails.php code
?>

<?php
include 'header.php';
?>

<?php
// Get the 'id' parameter from the URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Load JSON content from the file
$jsonFile = 'data.json'; // Replace with the actual path to your JSON file
$jsonContents = file_get_contents($jsonFile);
$allItems = json_decode($jsonContents, true);

// Find the item with the matching 'id'
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
// Get the ID from the URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
// echo $id;

// Validate and sanitize the ID (you might want to implement more robust validation)
// $id = preg_replace('/[^a-zA-Z0-9\-]/', '', $id);

if (empty($id)) {
    die("Invalid ID");
}

// Load comments from JSON file based on the ID
$filename = "comments/$id.json";
// echo $filename;

if (!file_exists($filename)) {
    die("Comments file not found");
}

$comments = file_get_contents($filename);
$comments = json_decode($comments, true);



    // Display comments in reverse order (newest first)
    if (isset($comments['comments/']) && is_array($comments['comments/'])) {
        $commentsArray = $comments['comments/'];
        $commentsArray = array_reverse($commentsArray);
        foreach ($commentsArray as $comment) {
            echo "<p><strong>{$comment['name']}</strong> ({$comment['timestamp']}): {$comment['comment']}</p>";
        }
    } else {
        echo "No comments yet.";
    }
    ?>
</div>



</body>
</html>



