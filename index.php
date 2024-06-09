<?php
/** @var mysqli $conn */
require_once 'database_connection.php';

// Definicja funkcji do pobierania lat zawodów
function getYears($conn)
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
function getChampionshipsForYear($conn, $year)
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
function getChampionshipInfo(mysqli $conn, $id){
    // Inicjalizacja tablicy do przechowywania szczegółowych informacji o zawodach
    $championshipInfo = [];

    // Przygotowanie warunku dla zapytania SQL
    $id = mysqli_real_escape_string($conn, $id);

    // Zapytanie SQL do pobierania szczegółowych informacji o zawodach
    $sql = "SELECT * FROM championships WHERE id='$id'";

    // Wykonanie zapytania SQL
    $result = mysqli_query($conn, $sql);

    // Jeśli znaleziono co najmniej jeden wynik, pobierz szczegółowe informacje o zawodach
    if (mysqli_num_rows($result) > 0) {
        $championshipInfo = mysqli_fetch_assoc($result);
    }

    // Zwraca szczegółowe informacje o zawodach
    return $championshipInfo;
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

    <!-- Link do strony dodania nowych zawodów -->
    <button onclick="location.href='add-form.php'"><?php echo "Rozpocznij"; ?></button>
</header>
<main>
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

<aside>
    <?php
    if (isset($_GET['info']) && $_GET['info'] !== '') {
        $selectedChampionship = getChampionshipInfo($conn, $_GET['info']);

        echo "<h2>Informacje o wybranych zawodach</h2>";
        echo "<p>ID: " . htmlentities($selectedChampionship['id']) . "</p>";
        echo "<p>Dyscyplina: " . htmlentities($selectedChampionship['discipline']) . "</p>";
        echo "<p>Kategoria: " . htmlentities($selectedChampionship['category']) . "</p>";
        echo "<p>Ilość tur: " . htmlentities($selectedChampionship['turns']) . "</p>";
        echo "<p>Data: " . htmlentities($selectedChampionship['date']) . "</p>";
        echo "<p>Czas rozpoczęcia: " . htmlentities($selectedChampionship['startTime']) . "</p>";
        echo "<p>Czas zakończenia: " . htmlentities($selectedChampionship['endTime']) . "</p>";
        echo "<p>Miejsce połowu: " . htmlentities($selectedChampionship['fishingLocation']) . "</p>";
        echo "<p>Miasto: " . htmlentities($selectedChampionship['city']) . "</p>";
        echo "<p>Nazwa: " . htmlentities($selectedChampionship['name']) . "</p>";
        echo "<p>Organizator: " . htmlentities($selectedChampionship['organiser']) . "</p>";
        echo "<p>Region: " . htmlentities($selectedChampionship['region']) . "</p>";
        echo "<p>Sędzia: " . htmlentities($selectedChampionship['referee']) . "</p>";
        echo "<p>Sekretarz: " . htmlentities($selectedChampionship['secretary']) . "</p>";
        echo "<p>Sektor Ref: " . htmlentities($selectedChampionship['sectorRef']) . "</p>";
        echo "<p>Control Ref: " . htmlentities($selectedChampionship['controlRef']) . "</p>";
    } else {
        echo "<h2>Wybierz zawody z listy</h2>";
    }
    ?>
</aside>
<footer>
    <h2>Dodaj nowe zawody</h2>
    <form method="post">
        <label for="discipline">Wybierz dyscyplinę:</label>
        <select name="discipline" id="discipline">
            <option value="Spławikowej*/Feederowej*">Spławikowej/Feederowej</option>
            <option value="Muchowej*/Spinningowej*">Muchowej/Spinningowej</option>
        </select>
        <br>
        <label for="category">Wybierz kategorię:</label>
        <select name="category" id="category">
            <option value="Kadet">Kadeci</option>
            <option value="Junior">Juniorzy</option>
            <option value="Młodzież">Młodzież</option>
            <option value="Kobiety">Kobiety</option>
            <option value="Senior">Seniorzy</option>
            <option value="Weterani U-55">Weterani U-55</option>
            <option value="Weterani U-65">Weterani U-65</option>
        </select>
        <br>
        <label for="turns">Wybierz ilość tur:</label>
        <input type="radio" name="turns" value="1" id="turns1" checked>
        <label for="turns1">1 tura</label>
        <input type="radio" name="turns" value="2" id="turns2">
        <label for="turns2">2 tury</label>
        <br>
        <label for="date">Wybierz datę zawodów:</label>
        <input type="date" name="date" id="date" required>
        <label for="startTime">Podaj godzinę rozpoczęcia:</label>
        <input type="time" name="startTime" id="startTime" required>
        <label for="endTime">Podaj godzinę zakończenia:</label>
        <input type="time" name="endTime" id="endTime" required>
        <br>
        <label for="fishingLocation">Podaj miejsce zawodów:</label>
        <input type="text" name="fishingLocation" id="fishingLocation" required>
        <label for="city">Podaj nazwę miejscowości:</label>
        <input type="text" name="city" id="city" required>
        <br>
        <label for="name">Podaj rodzaj zawodów:</label>
        <input type="text" name="name" id="name">
        <br>
        <label for="organiser">Podaj nazwę organizatora:</label>
        <input type="text" name="organiser" id="organiser" required>
        <label for="region">Podaj nr rejonu:</label>
        <input type="number" name="region" id="region" required>
        <br>
        <label for="referee">Podaj imię i nazwisko sędziego głównego:</label>
        <input type="text" name="referee" id="referee" required>
        <br>
        <label for="secretary">Podaj imię i nazwisko sędziego sekretarza:</label>
        <input type="text" name="secretary" id="secretary">
        <br>
        <label for="sectorRef">Podaj imię i nazwisko sędziego sektorowego:</label>
        <input type="text" name="sectorRef" id="sectorRef">
        <br>
        <label for="controlRef">Podaj imię i nazwisko sędziego kontrolnego/wagowego:</label>
        <input type="text" name="controlRef" id="controlRef">
        <br>
        <input type="checkbox" name="grandPrix" id="grandPrix">
        <label for="grandPrix">Zaznacz, jeżeli zawody liczą się do Grand Prix</label>
        <br><br>
        <input type="submit" value="Dodaj zawody">
        <input type="reset" value="Wyczyść formularz">
    </form>
</footer>
<?php
mysqli_close($conn)
?>
</body>
</html>