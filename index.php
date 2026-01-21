<?php
// index.php
// Include database connection
include_once 'config/database.php';

// Instantiate database object
$database = new Database();
$conn = $database->getConnection();

// Query to fetch all contacts
$query = "SELECT id, name, email, phone, created_at FROM contacts ORDER BY id ASC";
$stmt = $conn->prepare($query);
$stmt->execute();
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check for action messages
$message = '';
$message_class = '';

if(isset($_GET['action'])) {
    switch($_GET['action']) {
        case 'created':
            $message = 'Contact was created successfully!';
            $message_class = 'alert-success';
            break;
        case 'updated':
            $message = 'Contact was updated successfully!';
            $message_class = 'alert-success';
            break;
        case 'deleted':
            $message = 'Contact was deleted successfully!';
            $message_class = 'alert-success';
            break;
        case 'error':
            $message = 'Error occurred while performing the operation.';
            $message_class = 'alert-danger';
            break;
        case 'notfound':
            $message = 'Contact not found.';
            $message_class = 'alert-danger';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD - Contacts</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>My Contacts</h1>
        </div>
        
        <?php if(!empty($message)): ?>
            <div class="alert <?php echo $message_class; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <div class="add-new-btn">
            <a href="create.php" class="btn btn-primary">Add New Contact</a>
        </div>
        
        <?php if(count($contacts) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $row): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo date('M j, Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="read.php?id=<?php echo $row['id']; ?>" class="btn btn-info">View</a>
                                <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this contact?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No contacts found. Add your first contact using the button above.</div>
        <?php endif; ?>
    </div>
</body>
</html>