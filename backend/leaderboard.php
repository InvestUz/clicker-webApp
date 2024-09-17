<?php
header('Content-Type: application/json');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $db = new SQLite3('pizza_game.db');

    // Fetch leaderboard
    $result = $db->query('SELECT username, earnings FROM users ORDER BY earnings DESC LIMIT 10');

    $leaderboard = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $leaderboard[] = $row;
    }

    echo json_encode($leaderboard);
} catch (Exception $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
