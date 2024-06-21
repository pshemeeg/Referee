<?php
require 'db.php';

$championship_id = $_GET['id'];

// Pobieranie informacji o zawodach
$stmtChampionship = $db->prepare("SELECT * FROM Championships WHERE id = :id");
$stmtChampionship->execute(['id' => $championship_id]);
$championship = $stmtChampionship->fetch(PDO::FETCH_ASSOC);
$place = 1;
// Sprawdzenie ilości tur w zawodach
$rounds_count = $championship['rounds_count'];

// Pobieranie wyników
if ($rounds_count == 1) {
    // Zawody jednoturowe
    $stmtResults = $db->prepare("SELECT c.name, c.club, r.round, r.weight, r.points 
                                 FROM Results r 
                                 JOIN Contestants c ON r.contestant_id = c.id 
                                 WHERE r.championship_id = :id 
                                 ORDER BY r.points DESC");
} elseif ($rounds_count == 2) {
    // Zawody dwuturowe
    $stmtResults = $db->prepare("SELECT c.name, c.club, 
                                 SUM(CASE WHEN r.round = 1 THEN r.weight END) AS round1_weight,
                                 SUM(CASE WHEN r.round = 1 THEN r.points END) AS round1_points,
                                 SUM(CASE WHEN r.round = 2 THEN r.weight END) AS round2_weight,
                                 SUM(CASE WHEN r.round = 2 THEN r.points END) AS round2_points
                                 FROM Results r 
                                 JOIN Contestants c ON r.contestant_id = c.id 
                                 WHERE r.championship_id = :id 
                                 GROUP BY c.name, c.club 
                                 ORDER BY round1_points DESC, round2_points DESC");
}
$stmtResults->execute(['id' => $championship_id]);
$results = $stmtResults->fetchAll(PDO::FETCH_ASSOC);

// Pobieranie liczby wszystkich zawodników
$stmtCount = $db->prepare("SELECT COUNT(DISTINCT contestant_id) AS total FROM Results WHERE championship_id = :id");
$stmtCount->execute(['id' => $championship_id]);
$countResult = $stmtCount->fetch(PDO::FETCH_ASSOC);
$totalContestants = $countResult['total'];
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Szczegóły zawodów</title>
    <link rel="stylesheet" href="style.css">
    <script src="sort_table.js"></script>
    <style>
        /* Styl CSS dla tabeli */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<header>
    <h1>Szczegóły zawodów wędkarskich</h1>
</header>
<main>
    <section id="championshipDetails">
        <h2>Informacje o zawodach</h2>
        <p><strong>Dyscyplina:</strong> <?php echo $championship['discipline']; ?></p>
        <p><strong>Kategoria:</strong> <?php echo $championship['category']; ?></p>
        <p><strong>Ilość tur:</strong> <?php echo $championship['rounds_count']; ?></p>
        <p><strong>Data:</strong> <?php echo $championship['date']; ?></p>
        <p><strong>Godzina rozpoczęcia:</strong> <?php echo $championship['start_time']; ?></p>
        <p><strong>Godzina zakończenia:</strong> <?php echo $championship['end_time']; ?></p>
        <p><strong>Łowisko:</strong> <?php echo $championship['fishing_spot']; ?></p>
        <p><strong>Miejscowość:</strong> <?php echo $championship['location']; ?></p>
        <p><strong>Organizator:</strong> <?php echo $championship['organizer']; ?></p>
        <p><strong>Główny sędzia:</strong> <?php echo $championship['main_ref']; ?></p>
        <p><strong>Sekretarz:</strong> <?php echo $championship['secretary_ref']; ?></p>
        <p><strong>Wędkarz roku:</strong> <?php echo ($championship['fisherman_of_the_year'] ? 'Tak' : 'Nie'); ?></p>
    </section>

    <section id="results">
        <h2>Wyniki</h2>
        <p>Liczba wszystkich zawodników: <?php echo $totalContestants; ?></p>
        <table id="resultsTable">
            <thead>
            <tr>
                <th onclick="sortTable(0)">Lp</th>
                <th onclick="sortTable(1)"> Imię i nazwisko</th>
                <th onclick="sortTable(2)">Klub</th>
                <?php if ($rounds_count == 1): ?>
                    <th onclick="sortTable(3)">Waga</th>
                    <th onclick="sortTable(4)">Punkty</th>
                <?php elseif ($rounds_count == 2): ?>
                    <th colspan="2">Tura 1</th>
                    <th colspan="2">Tura 2</th>
                    <th>Suma waga</th>
                    <th>Suma punkty</th>
                <?php endif; ?>
                <th>Miejsce</th>
            </tr>
            </thead>
            <tbody>
            <?php $lp = 1; ?>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?php echo $lp++; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['club']; ?></td>
                    <?php if ($rounds_count == 1): ?>
                        <td><?php echo $row['weight']; ?></td>
                        <td><?php echo $row['points']; ?></td>
                        <td><?php echo $place++; ?></td>
                    <?php elseif ($rounds_count == 2): ?>
                        <td><?php echo $row['round1_weight']; ?></td>
                        <td><?php echo $row['round1_points']; ?></td>
                        <td><?php echo $row['round2_weight']; ?></td>
                        <td><?php echo $row['round2_points']; ?></td>
                        <td><?php echo ($row['round1_weight'] + $row['round2_weight']); ?></td>
                        <td><?php echo ($row['round1_points'] + $row['round2_points']); ?></td>
                        <td><?php echo $place++; ?></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <form id="newContestantsForm" action="add_contestants.php" method="post">
            <h2>Dodaj nowych zawodników</h2>
            <table id="newContestantsTable">
                <thead>
                <tr>
                    <th>Imię</th>
                    <th>Klub</th>
                    <?php if ($championship['rounds_count'] == 1): ?>
                        <th>Waga</th>
                        <th>Punkty</th>
                    <?php elseif ($championship['rounds_count'] == 2): ?>
                        <th>Waga 1</th>
                        <th>Punkty 1</th>
                        <th>Waga 2</th>
                        <th>Punkty 2</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="text" name="names[]" required></td>
                    <td><input type="text" name="clubs[]" required></td>
                    <?php if ($championship['rounds_count'] == 1): ?>
                        <td><input type="text" name="weights[]" required></td>
                        <td><input type="text" name="points[]" required></td>
                    <?php elseif ($championship['rounds_count'] == 2): ?>
                        <td><input type="text" name="weights[]" required></td>
                        <td><input type="text" name="points[]" required></td>
                        <td><input type="text" name="weights[]" required></td>
                        <td><input type="text" name="points[]" required></td>
                    <?php endif; ?>
                </tr>
                <!-- Można dodać więcej wierszy -->
                </tbody>
            </table>

            <input type="hidden" name="championship_id" value="<?php echo $championship_id; ?>">

            <button type="button" onclick="addRow()">Dodaj kolejnego zawodnika</button>
            <button type="submit">Zatwierdź wszystkich zawodników</button>
            <button type="button" onclick="clearForm()">Wyczyść formularz</button>
        </form>

    </section>
</main>
<script>
    function addRow() {
        const table = document.getElementById("newContestantsTable").getElementsByTagName('tbody')[0];
        const row = table.insertRow();

        // Pobierz liczbę tur zawodów
        const roundsCount = <?php echo $championship['rounds_count']; ?>;

        // Zdefiniuj treść wiersza w zależności od liczby tur
        let rowContent = `<td><input type="text" name="names[]" required></td><td><input type="text" name="clubs[]" required></td>`;

        if (roundsCount === 1) {
            rowContent += `<td><input type="text" name="weights[]" required></td><td><input type="text" name="points[]" required></td>`;
        } else if (roundsCount === 2) {
            rowContent += `<td><input type="text" name="weights[]" required></td><td><input type="text" name="points[]" required></td>`;
            rowContent += `<td><input type="text" name="weights[]" required></td><td><input type="text" name="points[]" required></td>`;
        }

        row.innerHTML = rowContent;
    }


    function clearForm() {
        document.getElementById("newContestantsForm").reset();
    }
</script>
</body>
</html>
