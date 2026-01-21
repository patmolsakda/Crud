# PHP CRUD Application - Contacts Manager

A simple PHP CRUD (Create, Read, Update, Delete) application for managing contacts using MySQL database.

## Features
- View all contacts
- Add new contacts
- View contact details
- Edit existing contacts
- Delete contacts
- Responsive design

## Requirements
- PHP 7.0 or higher
- MySQL 5.6 or higher
- Web server (Apache, Nginx, or PHP built-in server)

## Setup Instructions

### 1. Database Setup
First, create the database and table by importing the SQL file:

```bash
mysql -u root -p < setup.sql
```

Or manually run the SQL commands in your MySQL client.

### 2. Configure Database Connection
If needed, update the database credentials in `config/database.php`:
- `$host` - Database host (default: localhost)
- `$db_name` - Database name (default: contacts_db)
- `$username` - Database username (default: root)
- `$password` - Database password (default: empty)

### 3. Run the Application

#### Using PHP Built-in Server (Recommended for testing):
```bash
php -S localhost:8000
```

Then open your browser and navigate to: `http://localhost:8000`

#### Using XAMPP/WAMP:
1. Copy the project folder to `htdocs` (XAMPP) or `www` (WAMP)
2. Start Apache and MySQL
3. Navigate to `http://localhost/your-project-folder`

## File Structure
```
├── config/
│   └── database.php    # Database connection class
├── create.php          # Add new contact
├── read.php            # View contact details
├── update.php          # Edit contact
├── delete.php          # Delete contact
├── index.php           # List all contacts
├── style.css           # Styling
├── setup.sql           # Database setup script
└── README.md           # This file
```

## Usage
- **View Contacts**: The home page displays all contacts in a table
- **Add Contact**: Click "Add New Contact" button
- **View Details**: Click "View" button on any contact
- **Edit Contact**: Click "Edit" button on any contact
- **Delete Contact**: Click "Delete" button (with confirmation)

## Sample Data
The setup.sql file includes 3 sample contacts for testing.
