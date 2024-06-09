<?php
$servername = "localhost";
$username = "admin";
$password = "haslo";
$dbname = "Referee";

// Utwórz połączenie
$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdź połączenie
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}