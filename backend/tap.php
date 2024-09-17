<?php
include 'db_config.php';

$user_id = $_GET['user_id'];
$username = $_GET['username'];

// Check if the user already exists
$sql = "SELECT * FROM users WHERE telegram_id='$user_id'";
$result = $conn->query($sql);

if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $earnings = $row['earnings'] + 1;
    $sql = "UPDATE users SET earnings='$earnings' WHERE telegram_id='$user_id'";
} else {
    $earnings = 1;
    $sql = "INSERT INTO users (telegram_id, username, earnings) VALUES ('$user_id', '$username', '$earnings')";
}

if ($conn->exec($sql)) {
    echo json_encode(['earnings' => $earnings]);
} else {
    echo json_encode(['error' => 'Error updating earnings']);
}

$conn->close();
?>
