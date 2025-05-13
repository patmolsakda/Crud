<?php
// delete.php
// Check if id parameter exists
if(!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

// Include database connection
include_once 'config/database.php';

// Instantiate database object
$database = new Database();
$conn = $database->getConnection();

// Get contact ID
$id = $_GET['id'];

// Query to delete record
$query = "DELETE FROM contacts WHERE id = ?";
$stmt = $conn->prepare($query);

// Bind ID
$stmt->bindParam(1, $id);

// Execute query
if($stmt->execute()) {
    // Redirect to index page with success message
    header("Location: index.php?action=deleted");
} else {
    // Redirect to index page with error message
    header("Location: index.php?action=error");
}
?>



