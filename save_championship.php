<?php
// save_championship.php
require 'db.php';

$discipline = $_POST['discipline'];
$category = $_POST['category'];
$rounds_count = $_POST['rounds_count'];
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];
$fishing_spot = $_POST['fishing_spot'];
$location = $_POST['location'];
$name = $_POST['name'];
$organizer = $_POST['organizer'];
$main_ref = $_POST['main_ref'];
$secretary_ref = $_POST['secretary_ref'];
$fisherman_of_the_year = isset($_POST['fisherman_of_the_year']) ? 1 : 0;

try {
    $stmt = $db->prepare("INSERT INTO Championships 
        (discipline, category, rounds_count, date, start_time, end_time, fishing_spot, location, name, organizer, main_ref, secretary_ref, fisherman_of_the_year) 
        VALUES 
        (:discipline, :category, :rounds_count, :date, :start_time, :end_time, :fishing_spot, :location, :name, :organizer, :main_ref, :secretary_ref, :fisherman_of_the_year)");

    $stmt->execute([
        ':discipline' => $discipline,
        ':category' => $category,
        ':rounds_count' => $rounds_count,
        ':date' => $date,
        ':start_time' => $start_time,
        ':end_time' => $end_time,
        ':fishing_spot' => $fishing_spot,
        ':location' => $location,
        ':name' => $name,
        ':organizer' => $organizer,
        ':main_ref' => $main_ref,
        ':secretary_ref' => $secretary_ref,
        ':fisherman_of_the_year' => $fisherman_of_the_year
    ]);

    header('Location: list_championships.php');
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
