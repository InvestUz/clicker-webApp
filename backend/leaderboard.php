<?php
include 'db_config.php';

// Retrieve the top 10 players based on earnings
$sql = "SELECT username, earnings FROM users ORDER BY earnings DESC LIMIT 10";
$result = $conn->query($sql);

$leaderboard = [];

while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $leaderboard[] = ['username' => $row['username'], 'earnings' => $row['earnings']];
}

echo json_encode($leaderboard);
$conn->close();
?>
