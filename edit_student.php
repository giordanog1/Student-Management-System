<?php
session_start();
require_once "db_connect.php"; // Ensure this sets $conn

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$role = $_SESSION['role'];

if (!isset($_GET['id'])) {
    echo "No student ID provided.";
    exit();
}

$student_id = intval($_GET['id']);

// Check if student exists and belongs to the user (or user is admin)
if ($role === 'admin') {
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
} else {
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ? AND added_by = ?");
    $stmt->bind_param("ii", $student_id, $user_id);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Student not found or access denied.";
    exit();
}

$student = $result->fetch_assoc();

// Pre-fill values for the form
$name = $student["name"];
$email = $student["email"];
$course = $student["course"];
$age = $student["age"];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $course = $_POST["course"];
    $age = $_POST["age"];

    $update_stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, course = ?, age = ? WHERE id = ?");
    $update_stmt->bind_param("sssii", $name, $email, $course, $age, $student_id);

    if ($update_stmt->execute()) {
        echo "<p style='color: green;'>Student updated successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error updating student: " . $conn->error . "</p>";
    }

    $update_stmt->close();
}

$conn->close();
?>

<link rel="stylesheet" href="style.css">
<h2>Edit Student</h2>
<form method="post">
    Name: <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br>
    Email: <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
    Course: <input type="text" name="course" value="<?php echo htmlspecialchars($course); ?>" required><br>
    Age: <input type="number" name="age" value="<?php echo htmlspecialchars($age); ?>" required><br>
    <button type="submit">Update</button>
</form>

<a href="view_students.php">Back to Student List</a>
