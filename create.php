<?php
// create.php
// Check if form was submitted
if($_POST) {
    // Include database connection
    include_once 'config/database.php';
    
    // Instantiate database object
    $database = new Database();
    $conn = $database->getConnection();
    
    // Set contact property values
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    // Validate input
    $errors = [];
    if(empty($name)) $errors[] = "Name is required";
    if(empty($email)) $errors[] = "Email is required";
    if(empty($phone)) $errors[] = "Phone is required";
    
    // If no errors, proceed with insertion
    if(empty($errors)) {
        // Query to insert record
        $query = "INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        
        // Bind values
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $phone);
        
        // Execute query
        if($stmt->execute()) {
            // Record saved
            header("Location: index.php?action=created");
            exit();
        } else {
            $errors[] = "Unable to save contact.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Contact - PHP CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Add New Contact</h1>
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
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo isset($name) ? $name : ''; ?>" placeholder="Enter full name">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($email) ? $email : ''; ?>" placeholder="Enter email address">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="<?php echo isset($phone) ? $phone : ''; ?>" placeholder="Enter phone number">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Save Contact</button>
                    <a href="index.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>