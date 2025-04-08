<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($role);
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome, <?php echo $_SESSION["username"]; ?>!</h2>
        <p>This is your dashboard.</p>

        <?php if ($role == 'admin' || $role == 'student'): ?>
            <a href="add_student.php">
                <button class="dashboard-btn">Add Student</button>
            </a>
        <?php endif; ?>

    
        <?php if ($role == 'admin'|| $role == 'student'): ?>
            <a href="view_students.php">
                <button class="dashboard-btn">View Students</button>
            </a>
        <?php endif; ?>

        <a href="logout.php">
            <button class="dashboard-btn logout-btn">Logout</button>
        </a>
    </div>
</body>
</html>

