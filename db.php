<?php
try {
$db = new PDO('sqlite:competitions.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("CREATE TABLE IF NOT EXISTS Championships (
id INTEGER PRIMARY KEY,
discipline TEXT,
category TEXT,
rounds_count INTEGER,
date TEXT,
start_time TEXT,
end_time TEXT,
fishing_spot TEXT,
location TEXT,
name TEXT,
organizer TEXT,
main_ref TEXT,
secretary_ref TEXT,
fisherman_of_the_year BOOLEAN
)");

$db->exec("CREATE TABLE IF NOT EXISTS Contestants (
id INTEGER PRIMARY KEY,
name TEXT,
club TEXT
)");

$db->exec("CREATE TABLE IF NOT EXISTS Results (
id INTEGER PRIMARY KEY,
championship_id INTEGER,
contestant_id INTEGER,
round INTEGER,
weight REAL,
points REAL
)");
} catch (PDOException $e) {
echo $e->getMessage();
}
