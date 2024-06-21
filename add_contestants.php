<?php
require 'db.php';

$championship_id = $_POST['championship_id'];
$names = $_POST['names'];
$clubs = $_POST['clubs'];
$weights = $_POST['weights'];
$points = $_POST['points'];

$stmtChampionship = $db->prepare("SELECT * FROM championships WHERE id = :id LIMIT 1");
$stmtChampionship->execute(['id' => $championship_id]);
$championship = $stmtChampionship->fetch(PDO::FETCH_ASSOC);

$rounds_count = $championship['rounds_count'];

for($i = 0, $j = 0; $i < count($names); $i++){
    $name = $names[$i];
    $club = $clubs[$i];

    $stmtContestant = $db->prepare("SELECT * FROM contestants WHERE name = :name AND club = :club LIMIT 1");
    $stmtContestant->execute(['name' => $name, 'club' => $club]);
    $contestant = $stmtContestant->fetch(PDO::FETCH_ASSOC);

    if(!$contestant) {
        $stmtInsertContestant = $db->prepare("INSERT INTO contestants (name, club) VALUES (:name, :club)");
        $stmtInsertContestant->execute(['name'=>$name, 'club'=>$club]);
        $contestant_id = $db->lastInsertId();
    }else{
        $contestant_id = $contestant['id'];
    }

    for($round = 1; $round <= $rounds_count; $round++, $j++){
        $stmtInsertResult = $db->prepare("INSERT INTO results (championship_id, contestant_id, round, weight, points)
                                    VALUES (:championship_id, :contestant_id, :round, :weight, :points)");
        $stmtInsertResult->execute([
            'championship_id' => $championship_id,
            'contestant_id' => $contestant_id,
            'round' => $round,
            'weight' => $weights[$j],
            'points' => $points[$j]
        ]);
    }
}

header("Location: championship_details.php?id=".$championship_id);
?>