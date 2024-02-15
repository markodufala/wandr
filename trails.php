<?php
/**
 * Trails Page.
 *
 * This page displays a list of trails with the option to filter them by region.
 *
 * PHP version 7.0 and above
 *
 * @category Trails
 * @package  TrailsPage
 */

/**
 * Start the session to check user authentication.
 */
session_start();

/**
 * Check if the user is not logged in, redirect to login.php.
 */
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login.php');
    exit;
}

/**
 * Include the header.php file.
 */

/**
 * Get the current page from the query parameter.
 */
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$itemsPerPage = 12; // Number of items per page

/**
 * Load JSON file containing trail data.
 */
$jsonFile = 'data.json';
$jsonContents = file_get_contents($jsonFile);
$allItems = json_decode($jsonContents, true);

/**
 * Get the selected region number from 0 to 7.
 */
$selectedNumber = isset($_GET['number']) ? intval($_GET['number']) : null;

/**
 * Filter items based on the "number" attribute.
 */
$filteredItems = array_filter($allItems, function ($item) use ($selectedNumber) {
    return isset($item['number']) && ($selectedNumber === null || $item['number'] == $selectedNumber);
});

/**
 * Calculate the start and end index for the current page.
 */
$startIndex = ($page - 1) * $itemsPerPage;
$endIndex = $startIndex + $itemsPerPage;

/**
 * Get only items for the current page.
 */
$currentPageItems = array_slice($filteredItems, $startIndex, $itemsPerPage);

/**
 * Create links for previous and next pages.
 */
$prevPage = ($page > 1) ? $page - 1 : null;
$nextPage = ($endIndex < count($filteredItems)) ? $page + 1 : null;

/**
 * Calculate the total number of pages.
 */
$totalPages = ceil(count($filteredItems) / $itemsPerPage);

/**
 * Get a list of visible pages for navigation.
 */
$visiblePages = range(max(1, $page - 9), min($totalPages, $page + 10));
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wandr</title>
    <link rel="stylesheet" href="css/trails.css">
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">

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

    <h2>Vyber si kraj</h2>


    <form action="" method="get" id="selection">
    <label for="number">Vyberte kraj:</label>
    <select name="number" id="number">
        <option value="">Všetky kraje</option>
        <?php
        $regionNames = [
            'Bratislavský kraj',
            'Banskobystrický kraj',
            'Košický kraj',
            'Nitriansky kraj',
            'Trenčiansky kraj',
            'Trnavský kraj',
            'Prešovský kraj',
            'Žilinský kraj'
        ];
        for ($i = 0; $i <= 7; $i++):
        ?>
            <option value="<?php echo $i; ?>" <?php echo ($selectedNumber == $i) ? 'selected' : ''; ?>>
                <?php echo $regionNames[$i]; ?>
            </option>
        <?php endfor; ?>
    </select>
    <button type="submit">Filtrovať</button>
</form>


    <div class="grid">
        <?php foreach ($currentPageItems as $item): ?>
            <a href="hrebienok.php?id=<?php echo $item['id']; ?>">
                <div class="card">
                    <img src="<?php echo $item['img1']; ?>" alt="Image 1">
                    <div class="card-content">
                        <h2><?php echo $item['heading']; ?></h2>
                        <h3><?php echo $item['subheading']; ?></h3>
                        <h4><?php echo $item['subsubheading']; ?></h4>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <div id="numbering">
        <!-- Centrálny kontajner pre stránky -->
        <div class="page-container">
            <?php foreach ($visiblePages as $pageNumber): ?>
                <a href="?page=<?php echo $pageNumber; ?>" <?php echo ($pageNumber == $page) ? 'class="active"' : ''; ?>>
                    <?php echo $pageNumber; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Navigačný kontajner pre predchádzajúcu a ďalšiu stránku -->
        <div class="navigation-container">
            <?php if ($prevPage !== null): ?>
                <a href="?page=<?php echo $prevPage; ?>">Predchádzajúca stránka</a>
            <?php endif; ?>

            <?php if ($nextPage !== null): ?>
                <a href="?page=<?php echo $nextPage; ?>">Ďalšia stránka</a>
            <?php endif; ?>
        </div>

        <!-- Zobraziť informácie o stránkach -->
        <div>
            Stránka <?php echo $page; ?> z <?php echo $totalPages; ?>
        </div>

    </div>

    <footer>
        <img src="inverse_logo.svg" alt="">
    </footer>

</body>

</html>