<?php

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

$mysqli = new mysqli('localhost','root','','referee');

if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$sql = "INSERT INTO `zawody`(`discipline`, `category`, `turns`, `date`, `startTime`, `endTime`, `water`, `city`, `name`, `organiser`, `region`, `referee`, `secretary`, `sectorRef`, `controlRef`, `terrain`) VALUES ('$discipline','$category','$turns','$date','$startTime','$endTime','$water','$city','$name','$organiser','$region','$referee','$secretary','$sectorRef','$controlRef','$terrain')";


$mysqli -> query($sql); 

$mysqli -> close();
header('Location:index.php')
?>
