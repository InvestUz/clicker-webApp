<?php
include 'db_config.php';

$sql = "SELECT username, earnings FROM users ORDER BY earnings DESC LIMIT 10";
$result = $conn->query($sql);

$leaderboard = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $leaderboard[] = ['username' => $row['username'], 'earnings' => $row['earnings']];
    }
}

echo json_encode($leaderboard);
$conn->close();
?>
