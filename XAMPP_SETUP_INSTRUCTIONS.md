# XAMPP Setup Instructions for PHP CRUD Application

## Prerequisites
- XAMPP installed on your system (Download from: https://www.apachefriends.org/)

## Setup Steps

### Step 1: Start XAMPP Services
1. Open **XAMPP Control Panel**
2. Start **Apache** (click Start button)
3. Start **MySQL** (click Start button)
4. Both should show "Running" with green background

### Step 2: Copy Project to XAMPP Directory
1. Copy the entire project folder to XAMPP's `htdocs` directory
   - Default location: `C:\xampp\htdocs\`
   - You can rename the folder (e.g., `C:\xampp\htdocs\contacts-app\`)

### Step 3: Create MySQL Database
1. Open your browser and go to: **http://localhost/phpmyadmin**
2. Click on **"New"** in the left sidebar
3. Create a new database:
   - Database name: `contacts_db`
   - Collation: `utf8_general_ci`
   - Click **"Create"**

### Step 4: Import Database Table
1. In phpMyAdmin, select the `contacts_db` database (click on it)
2. Click on the **"SQL"** tab at the top
3. Copy and paste the following SQL code:

```sql
CREATE TABLE IF NOT EXISTS contacts (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO contacts (name, email, phone) VALUES
('John Doe', 'john.doe@example.com', '+1-555-0101'),
('Jane Smith', 'jane.smith@example.com', '+1-555-0102'),
('Bob Johnson', 'bob.johnson@example.com', '+1-555-0103');
```

4. Click **"Go"** button to execute

### Step 5: Configure Database Connection (if needed)
The default configuration is:
- **Host**: localhost
- **Database**: contacts_db
- **Username**: root
- **Password**: (empty)

If your XAMPP has different credentials, edit `config/database.php`:
```php
private $host = "localhost";
private $db_name = "contacts_db";
private $username = "root";
private $password = ""; // Add your password if any
```

### Step 6: Access the Application
Open your browser and go to:
```
http://localhost/Crud/
```
(Replace "Crud" with your actual folder name if different)

## Troubleshooting

### Issue: "Connection error" message
- **Solution**: Make sure MySQL is running in XAMPP Control Panel
- Check database credentials in `config/database.php`

### Issue: Apache won't start
- **Solution**: Port 80 might be in use by another application (Skype, IIS)
- Change Apache port in XAMPP Config or stop conflicting applications

### Issue: Page not found (404)
- **Solution**: Check the URL path matches your folder name in htdocs
- Example: If folder is `C:\xampp\htdocs\my-contacts\`, use `http://localhost/my-contacts/`

### Issue: Blank page
- **Solution**: Check PHP error logs in XAMPP Control Panel
- Enable error display by adding to index.php top:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## Current Project Location
Based on your workspace path: `C:\Users\ASUS\Crud`

To use with XAMPP:
1. Copy this folder to: `C:\xampp\htdocs\Crud\`
2. Access at: `http://localhost/Crud/`

## Database Files to Clean Up
The SQLite database file `contacts.db` is no longer needed and can be deleted since we're using MySQL now.
