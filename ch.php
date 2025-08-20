<?php
require 'db.php';

$id = (int)($_POST['id'] ?? 0);

if ($id > 0) {
    $sql = "UPDATE users SET Status = 1 - Status WHERE ID = $id";
    if (!$conn->query($sql)) {
        die("Update failed: " . $conn->error);
    }
}

header("Location: index.php");
exit;
?>