<?php
/** @var mysqli $conn */
require_once 'database_connection.php';

// Definicja funkcji do pobierania lat zawodów
function getYears($conn): array
{
    // Zapytanie SQL do pobierania unikalnych lat zawodów
    $query = "SELECT DISTINCT YEAR(date) AS year FROM championships";

    // Wykonanie zapytania SQL
    $result = $conn->query($query);

    // Zmienna do przechowywania lat
    $years = [];

    // Pętla do przetworzenia wyników zapytania
    while ($row = $result->fetch_assoc()) {
        $years[] = $row['year'];
    }

    // Zwraca tablicę lat
    return $years;
}

// Definicja funkcji do pobierania informacji o zawodach dla danego roku
function getChampionshipsForYear($conn, $year): array
{
    // Zapytanie SQL do pobierania informacji o zawodach dla danego roku
    $query = "SELECT id, date, startTime, endTime, name FROM championships WHERE YEAR(`date`) = $year";

    // Wykonanie zapytania SQL
    $result = mysqli_query($conn, $query);

    // Zmienna do przechowywania danych zawodów
    $championshipsData = [];

    // Pętla do przetworzenia wyników zapytania
    while ($row = mysqli_fetch_assoc($result)) {
        $championshipsData[] = $row;
    }

    // Zwraca tablicę danych zawodów
    return $championshipsData;
}

// Definicja funkcji do pobierania szczegółowych informacji o zawodach na podstawie podanego ID
function getChampionshipInfo(mysqli $conn, $id): array
{
    $championshipInfo = [];
    $stmt = $conn->prepare("SELECT * FROM championships WHERE id= ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $championshipInfo = $result->fetch_assoc();
    }
    return $championshipInfo;
}

function displayChampionshipInfo($championshipInfo): void
{
    if (!empty($championshipInfo)) {
        ob_clean();
        ob_start();
        ?>
        <h3><?php echo htmlentities($championshipInfo['id']) . ". " . htmlentities($championshipInfo['name']); ?></h3>
        <p><?php echo "Dyscyplina zawodów: " . htmlentities($championshipInfo['discipline']) . ". Kategoria: " . htmlentities($championshipInfo['category'])?></p>
        <p><?php echo "Zawody odbyły się w dniu: " . htmlentities($championshipInfo['date']) . ". W godzinach: " . htmlentities($championshipInfo['startTime']) . " - " . htmlentities($championshipInfo['endTime']); ?></p>
        <p><?php echo "Miejsce połowu: " . htmlentities($championshipInfo['fishingLocation']) . ", " . htmlentities($championshipInfo['city']); ?></p>
        <p><?php echo "Organizator: " . htmlentities($championshipInfo['organiser']) . ", Region: " . htmlentities($championshipInfo['region']); ?></p>
        <p><?php echo "Sędzia: " . htmlentities($championshipInfo['referee']) . ", Sekretarz: " . htmlentities($championshipInfo['secretary']); ?></p>
        <p><?php echo "Sektor Ref: " . htmlentities($championshipInfo['sectorRef']) . ", Control Ref: " . htmlentities($championshipInfo['controlRef']); ?></p>
        <?php
        $content = ob_get_clean();
        echo $content;

    } else {
        echo "<h2>Wybierz zawody z listy</h2>";
    }
}

// Pobranie lat zawodów
$years = getYears($conn);

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>Strona Główna</title>
</head>
<body>
<header style="text-align:center;padding-top:50px;">
    <h1>Witamy!</h1>
    <h3><?php echo "Podtytuł: " . date('H:i:s'); ?></h3>

    <!-- Link do formularza dodania nowych zawodów -->
    <button onclick="location.href='#add'"><?php echo "+ Dodaj nowe zawody +"; ?></button>
</header>
<aside id="add" style="display: none;">
    <h2>Dodaj nowe zawody</h2>
    <!-- Początek formularza, używamy metody POST do przesyłania danych na serwer -->
    <form method="post">
        <!-- Wybór dyscypliny -->
        <label for="discipline">Wybierz dyscyplinę:</label>
        <select name="discipline" id="discipline">
            <option value="Spławikowej*/Feederowej*">Spławikowej/Feederowej</option>
            <option value="Muchowej*/Spinningowej*">Muchowej/Spinningowej</option>
        </select>
        <br>

        <!-- Wybór kategorii -->
        <label for="category">Wybierz kategorię:</label>
        <select name="category" id="category">
            <option value="Kadet">Kadeci</option>
            <!-- etc. -->
        </select>
        <br>

        <!-- Wybór ilości tur -->
        <label for="turns">Wybierz ilość tur:</label>
        <!-- Opcja dla 1 tury -->
        <input type="radio" name="turns" value="1" id="turns1" checked>
        <label for="turns1">1 tura</label>
        <!-- Opcja dla 2 tur -->
        <input type="radio" name="turns" value="2" id="turns2">
        <label for="turns2">2 tury</label>
        <br>

        <!-- Wybór daty zawodów -->
        <label for="date">Wybierz datę zawodów:</label>
        <input type="date" name="date" id="date" required>
        <!-- Godzina rozpoczęcia zawodów -->
        <label for="startTime">Podaj godzinę rozpoczęcia:</label>
        <input type="time" name="startTime" id="startTime" required>
        <!-- Godzina zakończenia zawodów -->
        <label for="endTime">Podaj godzinę zakończenia:</label>
        <input type="time" name="endTime" id="endTime" required>
        <br>

        <!-- Miejsce zawodów -->
        <label for="fishingLocation">Podaj miejsce zawodów:</label>
        <input type="text" name="fishingLocation" id="fishingLocation" required>
        <!-- Nazwa miejscowości -->
        <label for="city">Podaj nazwę miejscowości:</label>
        <input type="text" name="city" id="city" required>
        <br>

        <!-- Rodzaj zawodów -->
        <label for="name">Podaj rodzaj zawodów:</label>
        <input type="text" name="name" id="name">
        <br>

        <!-- Nazwa organizatora -->
        <label for="organiser">Podaj nazwę organizatora:</label>
        <input type="text" name="organiser" id="organiser" required>
        <!-- Nr rejonu -->
        <label for="region">Podaj nr rejonu:</label>
        <input type="number" name="region" id="region" required>
        <br>

        <!-- Imię i nazwisko sędziego głównego -->
        <label for="referee">Podaj imię i nazwisko sędziego głównego:</label>
        <input type="text" name="referee" id="referee" required>
        <br>

        <!-- Imię i nazwisko sędziego sekretarza -->
        <label for="secretary">Podaj imię i nazwisko sędziego sekretarza:</label>
        <input type="text" name="secretary" id="secretary">
        <br>

        <!-- Imię i nazwisko sędziego sektorowego -->
        <label for="sectorRef">Podaj imię i nazwisko sędziego sektorowego:</label>
        <input type="text" name="sectorRef" id="sectorRef">
        <br>

        <!-- Imię i nazwisko sędziego kontrolnego/wagowego -->
        <label for="controlRef">Podaj imię i nazwisko sędziego kontrolnego/wagowego:</label>
        <input type="text" name="controlRef" id="controlRef">
        <br>

        <!-- Opcja dla zawodów liczących się do Grand Prix -->
        <input type="checkbox" name="grandPrix" id="grandPrix">
        <label for="grandPrix">Zaznacz, jeżeli zawody liczą się do Grand Prix</label>
        <br><br>

        <!-- Przycisk do przesyłania formularza -->
        <input type="submit" value="Dodaj zawody">
        <!-- Przycisk resetuje formularz do jego stanu początkowego -->
        <input type="reset" value="Wyczyść formularz">
    </form>
    <!-- Koniec formularza -->
</aside>
<main id="list">
    <h2>Wróćmy do tamtych lat</h2>

    <!-- Wyświetlanie lat zawodów -->
    <?php foreach ($years as $yearOption) : ?>
        <details>
            <summary><?php echo $yearOption; ?></summary>

            <!-- Pobieranie danych zawodów dla danego roku -->
            <?php $championshipsData = getChampionshipsForYear($conn, $yearOption); ?>

            <ul>
                <!-- Wyświetlanie danych zawodów -->
                <?php foreach ($championshipsData as $championship) : ?>
                    <?php
                    $championshipInfo = "Data: " . $championship["date"] . ", Czas rozpoczęcia: " . $championship["startTime"] . ", Czas zakończenia: " . $championship["endTime"] . ", Nazwa: " . $championship["name"];
                    $championshipLink = "?info=" . $championship['id'];
                    ?>
                    <li>
                        <!-- Wyświetlanie informacji o zawodach i linku do szczegółów -->
                        <?php echo $championshipInfo; ?>
                        <?php echo " <a href='$championshipLink'>Więcej szczegółów >>;</a>"; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </details>
    <?php endforeach; ?>
</main>

<aside id="info">
    <?php
    if (isset($_GET['info']) && $_GET['info'] !== '') {
        $selectedChampionship = getChampionshipInfo($conn, $_GET['info']);

        echo "<h2>Informacje o wybranych zawodach</h2>";
        displayChampionshipInfo($selectedChampionship);
    } else {
        echo "<h2>Wybierz zawody z listy</h2>";
    }
    ?>
</aside>
<?php
mysqli_close($conn)
?>
</body>
</html>