<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $email = $_POST["email"]; // Get email from the form
    $password = $_POST["password"];

    // Validate email, username, and password
    if (empty($email) || empty($password) || empty($username)) {
        echo "All fields are required!";
    } else {
        // Check if the email already exists in the database
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "This email is already registered.";
        } else {
            // Proceed with registration (Hash the password)
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert user data into the users table
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                echo "Registration successful! <a href='login.php'>Login</a>";
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }
}

$conn->close();
?>

<link rel="stylesheet" href="style.css">
<form method="post">
    Username: <input type="text" name="username" required><br>
    Email: <input type="email" name="email" required><br>  
    Password: <input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>
