<?php
header('Content-Type: application/json');

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

if ($user_id) {
    $db = new SQLite3('pizza_game.db');

    // Check if user exists
    $stmt = $db->prepare('SELECT * FROM users WHERE user_id = :user_id');
    $stmt->bindValue(':user_id', $user_id, SQLITE3_TEXT);
    $result = $stmt->execute();
    
    if ($result->fetchArray()) {
        // User exists, update earnings
        $stmt = $db->prepare('UPDATE users SET earnings = earnings + 1 WHERE user_id = :user_id');
        $stmt->bindValue(':user_id', $user_id, SQLITE3_TEXT);
        $stmt->execute();
    } else {
        // New user
        $stmt = $db->prepare('INSERT INTO users (user_id, username, earnings) VALUES (:user_id, :username, 1)');
        $stmt->bindValue(':user_id', $user_id, SQLITE3_TEXT);
        $stmt->bindValue(':username', isset($_GET['username']) ? $_GET['username'] : '', SQLITE3_TEXT);
        $stmt->execute();
    }

    // Fetch updated earnings
    $stmt = $db->prepare('SELECT earnings FROM users WHERE user_id = :user_id');
    $stmt->bindValue(':user_id', $user_id, SQLITE3_TEXT);
    $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    echo json_encode(['earnings' => $result['earnings']]);
} else {
    echo json_encode(['error' => 'User ID is required']);
}
?>
