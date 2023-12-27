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
    <link rel="stylesheet" href="css/trails/hrebienok.css">
    <title><?php echo $selectedItem['heading']; ?></title>
</head>
<body>
    <section id="stats">
    <h1><?php echo $selectedItem['heading']; ?></h1>

    <img class="main-image" src="img/Hero_img.png" alt="" id="main_img">


    <h2>Náročnosť</h2>

    
    <span class="dot rating1"></span>
    <span class="dot rating1"></span>
    <span class="dot rating1"></span>
    <span class="dot rating1"></span>
    <span class="dot rating1"></span>

    <h2>Výhlady</h2>



    <span class="dot rating2"></span>
    <span class="dot rating2"></span>
    <span class="dot rating2"></span>
    <span class="dot rating2"></span>
    <span class="dot rating2"></span>

    <h2>Dav</h2>

    <span class="dot rating3"></span>
    <span class="dot rating3"></span>
    <span class="dot rating3"></span>
    <span class="dot rating3"></span>
    <span class="dot rating3"></span>

    <h2>Ročné obdobia</h2>
    <span class="bigger-dot">Leto</span>

    </section>

    <img class="gallery-image" src="img/Hero_img.png" alt="" id="gallery_image">

    <section id="info">
        <h3>Popis túry</h3>
        <?php echo $selectedItem['paragraph1']; ?>
        <br>
        <br>
        <br>
        <br>

        <?php echo $selectedItem['paragraph2']; ?>
    </section>

    <h4>Trasa: Starý smokovec – Hrebienok – Starý smokovec</h4>

    <table>
        <tr>
            <td>Dĺžka trasy</td>
            <td>4.8 Km</td>
        </tr>
        <tr>
            <td>Časová náročnosť</td>
            <td>1:45 h</td>
        </tr>
        <tr>
            <td>Výškové prevýšenie</td>
            <td>266 m</td>
        </tr>
    </table>

    <h3>Komentáre</h3>



<div class="container" id="main">
    <form id="comment-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" rows="4" required></textarea>

        <input type="submit" value="Submit Comment">
    </form>

    <div class="comments">
        <div class="comment">
            <p class="user">John Doe</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget justo et massa facilisis ullamcorper.</p>
            <p class="time">Posted on: January 1, 2023</p>
        </div>

        <div class="comment">
            <p class="user">Jane Smith</p>
            <p>Quisque et justo vitae diam consequat accumsan a id ligula. Nulla facilisi.</p>
            <p class="time">Posted on: January 2, 2023</p>
        </div>
    </div>
</div>

</body>
</html>



