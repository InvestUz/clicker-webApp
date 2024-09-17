<?php
include 'db_config.php';

$user_id = $_GET['user_id'];
$username = $_GET['username'];

$sql = "SELECT * FROM users WHERE telegram_id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $earnings = $row['earnings'] + 1;
    $sql = "UPDATE users SET earnings='$earnings' WHERE telegram_id='$user_id'";
} else {
    $earnings = 1;
    $sql = "INSERT INTO users (telegram_id, username, earnings) VALUES ('$user_id', '$username', '$earnings')";
}

if ($conn->query($sql) === TRUE) {
    echo json_encode(['earnings' => $earnings]);
} else {
    echo json_encode(['error' => 'Error updating earnings']);
}

$conn->close();
?>
