<!-- add_championship.php -->
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj nowe zawody</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Dodaj nowe zawody</h1>
</header>
<main>
    <form action="save_championship.php" method="post">
        <label for="discipline">Dyscyplina:</label>
        <select id="discipline" name="discipline">
            <option value="spławikowe">Spławikowe</option>
            <option value="feederowe">Feederowe</option>
            <option value="spinningowe">Spinningowe</option>
        </select>

        <label for="category">Kategoria:</label>
        <select id="category" name="category">
            <option value="junior">Junior</option>
            <option value="senior">Senior</option>
            <option value="veteran">Weteran</option>
        </select>

        <label for="rounds_count">Ilość tur:</label>
        <input type="radio" id="one_round" name="rounds_count" value="1">
        <label for="one_round">1</label>
        <input type="radio" id="two_rounds" name="rounds_count" value="2">
        <label for="two_rounds">2</label>

        <label for="date">Data:</label>
        <input type="date" id="date" name="date">

        <label for="start_time">Godzina rozpoczęcia:</label>
        <input type="time" id="start_time" name="start_time">

        <label for="end_time">Godzina zakończenia:</label>
        <input type="time" id="end_time" name="end_time">

        <label for="fishing_spot">Łowisko:</label>
        <input type="text" id="fishing_spot" name="fishing_spot">

        <label for="location">Miejscowość:</label>
        <input type="text" id="location" name="location">

        <label for="name">Nazwa zawodów:</label>
        <input type="text" id="name" name="name">

        <label for="organizer">Organizator:</label>
        <input type="text" id="organizer" name="organizer">

        <label for="main_ref">Główny sędzia:</label>
        <input type="text" id="main_ref" name="main_ref">

        <label for="secretary_ref">Sekretarz:</label>
        <input type="text" id="secretary_ref" name="secretary_ref">

        <label for="fisherman_of_the_year">Wędkarz roku:</label>
        <input type="checkbox" id="fisherman_of_the_year" name="fisherman_of_the_year">

        <input type="submit" value="Dodaj zawody">
    </form>
</main>
</body>
</html>
