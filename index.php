<?php
require 'db.php';


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["Name"], $_POST["Age"])) {
    $name = $conn->real_escape_string($_POST["Name"]);
    $age = (int) $_POST["Age"];

    $sql = "INSERT INTO users (Name, Age, Status) VALUES ('$name', $age, 0)";
    if (!$conn->query($sql)) {
        die("Insert failed: " . $conn->error);
    }
    header("Location: index.php");
    exit;
}


$result = $conn->query("SELECT * FROM users ORDER BY ID ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Status Page</title>
    <style>
        body {font-family: Arial; background: #f7f7f7; text-align: center;}
        form {margin: 20px;}
        input, button {padding: 6px; margin: 4px;}
        table {margin:auto; border-collapse:collapse; width:70%; background:#fff;}
        th, td {border:1px solid #000; padding:8px; text-align:center;}
        th {background:#4CAF50; color:#fff;}
        a.toggle-btn {background:#2196F3; color:#fff; padding:5px 10px; text-decoration:none;}
        a.toggle-btn:hover {background:#0b7dda;}
    </style>
</head>
<body>

<h2>Add New User</h2>
<form method="POST">
    <input type="text" name="Name" placeholder="Enter Name" required>
    <input type="number" name="Age" placeholder="Enter Age" required>
    <button type="submit">Submit</button>
</form>

<h2>Users Table</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Age</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['ID']) ?></td>
                <td><?= htmlspecialchars($row['Name']) ?></td>
                <td><?= htmlspecialchars($row['Age']) ?></td>
                <td><?= $row['Status'] ?></td>
                <td>
                    <form action="ch.php" method="POST">
                        <input type="hidden" name="id" value="<?= $row['ID'] ?>">
                        <button type="submit">Toggle</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="5">No records found</td></tr>
    <?php endif; ?>
</table>

</body>
</html>