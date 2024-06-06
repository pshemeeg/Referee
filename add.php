<?php
#Pobranie wartości z formularza do zmiennych !Trzeba dowiedzieć się czy da się to zrobić lepiej!
$discipline = $_POST['discipline'];
$category = $_POST['category'];
$turns = $_POST['turns'];
$date = $_POST['date'];
$startTime = $_POST['startTime'];
$endTime = $_POST['endTime'];
$water = $_POST['water'];
$city = $_POST['city'];
$name = $_POST['name'];
$organiser = $_POST['organiser'];
$region = $_POST['region'];
$referee = $_POST['referee'];
$secretary = $_POST['secretary'];
$sectorRef = $_POST['sectorRef'];
$controlRef = $_POST['controlRef'];
$terrain = $_POST['terrain'];
#Otwarcie połączenia z bazą danych
$mysqli = new mysqli('localhost','root','','referee');
#Sprawdzenie czy połączenie się udało
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
#Kwerenda SQL do wykonania na bazie danych dodanie nowych zawodów do tabeli "zawody" !Trzeba to przerobić na sprintf żeby jakoś wyglądało!
$sql = "INSERT INTO `zawody`(`discipline`, `category`, `turns`, `date`, `startTime`, `endTime`, `water`, `city`, `name`, `organiser`, `region`, `referee`, `secretary`, `sectorRef`, `controlRef`, `terrain`) VALUES ('$discipline','$category','$turns','$date','$startTime','$endTime','$water','$city','$name','$organiser','$region','$referee','$secretary','$sectorRef','$controlRef','$terrain')";
#Wykonanie kwerendy na bazie danych
$mysqli -> query($sql); 
#Zamknięcie połączenia z bazą
$mysqli -> close();
#Przekierowanie na stronę główną
header('Location:index.php')
?>
