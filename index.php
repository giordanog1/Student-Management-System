<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="index.css"> 
</head>
<body>
    <!-- Main Container for the Page -->
    <div class="main-container">
        
        <!-- Header Section -->
        <header>
            <h1>Student Management System</h1>
            <p>Manage your student records with ease. Login or Register to get started.</p>
        </header>

        <!-- Login/Register Section -->
        <section class="auth-section">
            <div class="auth-buttons">
                <a href="login.php" class="btn btn-primary">Login</a>
                <a href="register.php" class="btn btn-secondary">Register</a>
            </div>
        </section>

        <!-- Footer Section -->
        <footer>
            <p>&copy; Created by Giordano Galarce. All Rights Reserved.</p>
        </footer>
    </div>
</body>
</html>
