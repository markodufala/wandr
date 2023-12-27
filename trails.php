<?php include 'header.php';?>


<?php
    // Získajte aktuálnu stránku zo query parametra
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $itemsPerPage = 12; // Počet položiek na stránku

    // Načítajte JSON súbor
    $jsonFile = 'data.json';
    $jsonContents = file_get_contents($jsonFile);
    $allItems = json_decode($jsonContents, true);

    // Vypočítajte začiatočný a koncový index pre aktuálnu stránku
    $startIndex = ($page - 1) * $itemsPerPage;
    $endIndex = $startIndex + $itemsPerPage;

    // Získajte iba položky pre aktuálnu stránku
    $currentPageItems = array_slice($allItems, $startIndex, $itemsPerPage);

    // Vytvorte odkazy na predchádzajúce a ďalšie stránky
    $prevPage = ($page > 1) ? $page - 1 : null;
    $nextPage = ($endIndex < count($allItems)) ? $page + 1 : null;

    // Vypočítajte celkový počet strán
    $totalPages = ceil(count($allItems) / $itemsPerPage);

    // Získajte zoznam stránok na zobrazenie v navigácii
    $visiblePages = range(1, min($totalPages, 10));


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
    <h2>Vyber si kraj</h2>


<div class="grid">
        <?php foreach ($currentPageItems as $item): ?>
            <a href="hrebienok.php?id=<?php echo $item['id']; ?>">
                <div class="card">
                    <img src="img/Hero_img.png" alt="Image 1">
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