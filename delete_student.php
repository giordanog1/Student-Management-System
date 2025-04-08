<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch student ID from URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Fetch student record for confirmation
    $stmt = $conn->prepare("SELECT id, name FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $name);
    $stmt->fetch();

    // Check if the student exists
    if ($stmt->num_rows == 0) {
        echo "Student not found.";
        exit();
    }
} else {
    echo "Invalid student ID.";
    exit();
}

// Handle deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    // Delete student record
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        echo "Student record deleted successfully! <a href='view_students.php'>Back to Student List</a>";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
}

// Close connection
$conn->close();
?>

<h2>Confirm Deletion</h2>
<p>Are you sure you want to delete the student record for <?php echo $name; ?>?</p>

<form method="post">
    <button type="submit" name="confirm_delete" value="yes">Yes, Delete</button>
    <a href="view_students.php">No, Cancel</a>
</form>