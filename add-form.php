<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dodaj nowe zawody</title>
</head>
<body>
<!--Nagłówek strony tytuł i logo nic więcej tutaj nie chcemy ewentualnie później jakiś prosty baner-->
<header>
<h1>Zawody koła PZW nr 8 w Bieruniu Nowym</h1>
</header>
<!--Główna zawartość strony formularz dodawania nowych zawodów Wymaga redesignu-->
<main>
<h2>Dodawanie nowych zawodów</h2>
<!--Formularz wysyła dane do pliku add.php który dodaje zawody do bazy i tworzy nową tabelę dla danych zawodów-->
<form action="add.php" method="post">
<label for="discipline">Dyscyplina: </form>
<select name="discipline" id="discipline">
  <option value="Spławikowej*/Feederowej*">Spławikowej/Feederowej</option>
  <option value="Muchowej*/Spinningowej*"> Muchowej/Spinningowej</option>
</select>
<br>
<label for="category">Kategoria:</label>
<select name="category" id="category">
  <option value="Kadet">Kadeci</option>
  <option value="Junior">Juniorzy</option>
  <option value="Młodzierz">Młodzierz</option>
  <option value="Kobiety">Kobiety</option>
  <option value="Senior">Seniorzy</option>
  <option value="Weterani U-55">Weterani U-55</option>
  <option value="Weterani U-65">Weterani U-65</option>
</select>
<br>
<label for="turns">Ilość tur: </label>
<input type="number" name="turns" id="turns" min="1" max="2" required>
<br>
<label for="date">W dniu: </label>
<input type="date" name="date" id="date" required>
<label for="startTime">W godzinach: </label>
<input type="time" name="startTime" id="startTime" required>
<label for="endTime"> - </label>
<input type="time" name="endTime" id="endTime" required>
<br>
<!--Wymienić input text na select dla wyboru łowiska-->
<label for="water">Na wodzie: </label>
<input type="text" name="water" id="water" required>
<label for="city">W miejscowości: </label>
<input type="text" name="city" id="city" required>
<br>
<label for="name">Rodzaj zawodów:</label>
<input type="text" name="name" id="name">
<br>
<label for="organiser">Organizator Koło/Klub PZW: </label>
<input type="text" name="organiser" id="organiser" required>
<label for="region">Rejon nr: </label>
<input type="numer" name="region" id="region" required>
<br>
<h3>Komisja sędziowska:</h3>
<br>
<label for="referee">Sędzia główny: </label>
<input type="text" name="referee" id="referee" required>
<br>
<label for="secretary">Sędzia sekretarz: </label>
<input type="text" name="secretary" id="secretary">
<br>
<label for="sectorRef">Sędzia sektorowy: </label>
<input type="text" name="sectorRef" id="sectorRef">
<br>
<label for="controlRef">Sędzia kontrolny/wagowy:</label>
<input type="text" name="controlRef" id="controlRef">
<br>
<h3>Przygotowanie terenu: </h3>
<input type="radio" name="terrain" id="terrain1" value="true" checked>
<label for="terrain1">należyte</label>
<input type="radio" name="terrain" id="terrain2" value="true">
<label for="terrain2">wadliwe</label>
<br><br>
<input type="submit" value="Dodaj zawody">
<input type="reset" value="Wyczyść formularz">
</form>
</body>
</html>
