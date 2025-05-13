<?php
// read.php

// Check if id parameter exists and is numeric
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?action=notfound");
    exit();
}

// Include database connection
include_once 'config/database.php';

// Instantiate database object
$database = new Database();
$conn = $database->getConnection();

// Get contact ID
$id = intval($_GET['id']);

// Query to read single record
$query = "SELECT id, name, email, phone, created_at FROM contacts WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $id, PDO::PARAM_INT);
$stmt->execute();

// Get retrieved row
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if record exists
if (!$row) {
    header("Location: index.php?action=notfound");
    exit();
}

// Extract row
$name = $row['name'];
$email = $row['email'];
$phone = $row['phone'];
$created_at = $row['created_at'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contact - PHP CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Contact Details</h1>
        </div>

        <div class="card">
            <div class="card-header">
                <h2><?php echo htmlspecialchars($name); ?></h2>
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> <?php echo $id; ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
                <p><strong>Created:</strong> <?php echo date('F j, Y \a\t g:i a', strtotime($created_at)); ?></p>
            </div>
            <div class="card-footer">
                <a href="index.php" class="btn btn-default">Back to List</a>
                <a href="update.php?id=<?php echo $id; ?>" class="btn btn-warning">Edit Contact</a>
                <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this contact?')">Delete Contact</a>
            </div>
        </div>
    </div>
</body>
</html>
