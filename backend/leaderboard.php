<?php
header('Content-Type: application/json');

$db = new SQLite3('pizza_game.db');

// Fetch leaderboard
$result = $db->query('SELECT username, earnings FROM users ORDER BY earnings DESC LIMIT 10');

$leaderboard = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $leaderboard[] = $row;
}

echo json_encode($leaderboard);
?>
