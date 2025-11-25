<?php
function addLog($conn, $actor_id, $type, $action)
{
    $stmt = $conn->prepare("
        INSERT INTO logs (actor_id, account_type, action)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("iss", $actor_id, $type, $action);
    $stmt->execute();
}
