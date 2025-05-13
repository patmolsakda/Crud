<?php
// update.php
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

// Check if form was submitted
if($_POST) {
    // Set contact property values
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    // Validate input
    $errors = [];
    if(empty($name)) $errors[] = "Name is required";
    if(empty($email)) $errors[] = "Email is required";
    if(empty($phone)) $errors[] = "Phone is required";
    
    // If no errors, proceed with update
    if(empty($errors)) {
        // Query to update record
        $query = "UPDATE contacts SET name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        // Bind values
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $phone);
        $stmt->bindParam(4, $id);
        
        // Execute query
        if($stmt->execute()) {
            // Record updated
            header("Location: index.php?action=updated");
            exit();
        } else {
            $errors[] = "Unable to update contact.";
        }
    }
} else {
    // Query to read single record
    $query = "SELECT id, name, email, phone FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    // Bind ID
    $stmt->bindParam(1, $id);
    
    // Execute query
    $stmt->execute();
    
    // Get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check if record exists
    if(!$row) {
        header("Location: index.php?action=notfound");
        exit();
    }
    
    // Extract row
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact - PHP CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Edit Contact</h1>
        </div>
        
        <?php if(!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-header">
                <h2>Editing: <?php echo htmlspecialchars($name); ?></h2>
            </div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id={$id}"; ?>" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="<?php echo htmlspecialchars($phone); ?>">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Contact</button>
                    <a href="index.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>