<!-- list_championships.php -->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Lista zawodów wędkarskich koła PZW</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Lista zawodów wędkarskich koła PZW</h1>
</header>
<main>
    <?php
    require 'db.php';

    $stmt = $db->query("SELECT DISTINCT strftime('%Y', date) AS year FROM Championships ORDER BY year DESC");
    $years = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($years as $year) {
        echo "<h2>Zawody z roku: {$year['year']}</h2>";

        $stmt = $db->prepare("SELECT * FROM Championships WHERE strftime('%Y', date) = :year");
        $stmt->execute(['year' => $year['year']]);
        $championships = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($championships as $championship) {
            echo "<article>
                        <h3>{$championship['name']}</h3>
                        <p>Data: {$championship['date']}</p>
                        <a href='championship_details.php?id={$championship['id']}'>Więcej szczegółów</a>
                      </article>";
        }
    }
    ?>
</main>
</body>
</html>
