<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Zawody koła pzw 8</title>
</head>

<body>
  <!--Nagłówek strony tytuł i logo nic więcej tutaj nie chcemy ewentualnie później jakiś prosty baner-->
  <header>
    <h1>Zawody koła PZW nr 8 w Bieruniu Nowym</h1>
  </header>
  <!--Główna zawartość strony lista wszystkich zawodów w przyszłości potrzebny będzie podział zawodów ze wzgędu na rok w którym się odbyły-->
  <main>
    <h2>Wybierz zawody z listy lub dodaj nowe.</h2>
    <!--Lista zawierająca przyciski do informacji na temat danych zawodów 
        ?Czy przyciski to dobry pomysł czy nie zamienić tego na krótkie paragrafy/artykuły?-->
    <ul>
      <?php
      #połączenie z bazą danych
      $mysqli = new mysqli('localhost', 'root', '', 'referee');
      #sprawdzenie połączenia z bazą
      if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
      }
      #Kwerenda SQL do wykonania na bazie danych dodanie nowych zawodów do tabeli "zawody" !Trzeba to przerobić na sprintf żeby jakoś wyglądało!
      $sql = "";
      #Wykonanie kwerendy na bazie danych
      $mysqli->query($sql);
      #Zamknięcie połączenia z bazą
      ?>
    </ul>
    <!--Link do formularza dodającego nowe zawody !Pod listą to złe miejsce!-->
    <a href="add-form.php">Dodaj nowe zawody!</a>
  </main>
</body>

</html>
