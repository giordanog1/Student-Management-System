# 🎓 Student Management System

A simple role-based web application built using **PHP** and **MySQL** that allows users to register, log in, and manage student records based on their assigned role.

## 🚀 Features

### ✅ Authentication
- User registration & login with session handling
- Passwords securely hashed
- Role-based access control: **admin** and **student**

### ✅ Role-Based Functionality

#### Admin Users:
- View all student records
- Add, edit, and delete any student
- View and edit all registered users (change roles)
- Full dashboard access

#### Student Users:
- Add student records
- View all student records
- Edit only the records they have added
- Cannot delete records or modify users

### ✅ Student Management
- Add Student
- Edit Student
- View all Students
- Delete Student (admin only)
- Shows who added each student

### ✅ Clean UI
- Dashboard interface styled with responsive CSS
- Confirmation prompts for deletion actions
- Clear error and success messages

## 🛠️ Technologies Used

- PHP (Procedural)
- MySQL (MariaDB)
- HTML/CSS (Vanilla)
- phpMyAdmin (for database interaction)
- MySQLi for database operations
  
## 📦 Database Structure

### `users` Table
| Field      | Type         | Description                  |
|------------|--------------|------------------------------|
| id         | INT (PK)     | Auto-increment user ID       |
| username   | VARCHAR      | Unique username              |
| password   | VARCHAR      | Hashed password              |
| role       | ENUM         | 'admin' or 'student'         |

### `students` Table
| Field      | Type         | Description                  |
|------------|--------------|------------------------------|
| id         | INT (PK)     | Auto-increment student ID    |
| name       | VARCHAR      | Student's full name          |
| email      | VARCHAR      | Student's email              |
| course     | VARCHAR      | Enrolled course              |
| age        | INT          | Student age                  |
| added_by   | INT (FK)     | Linked to `users.id`         |

## ⚙️ Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/student-management-system.git

    Import the database:

        Open phpMyAdmin

        Create a new database named student_db

        Import student_db.sql located in the project folder

    Update database credentials in db_connect.php:

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "student_db";

    Run the app:

        Place the project folder inside htdocs (for XAMPP) or your web server’s root

        Start Apache and MySQL from XAMPP

        Visit http://localhost/student-management-system/ in your browser

👥 Admin Credentials

By default, the user with the username admin is assigned the admin role.

    Make sure to register this user first to enable admin capabilities.

🔐 Security Notes

    All inputs are sanitized using prepared statements (MySQLi)

    Sessions are used for login/logout management

    Users can only access features allowed by their role

🧾 License

This project is open source and free to use for educational purposes.

Made with 💻 by Giordano Galarce
