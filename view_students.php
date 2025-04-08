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

$sql = "SELECT * FROM students";
$result = $conn->query($sql);

echo "<h2>View Students</h2>";
echo "<table border='1'><tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Age</th><th>Added By</th><th>Actions</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $student_id = $row["id"];
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["course"] . "</td><td>" . $row["age"] . "</td><td>" . $row["added_by"] . "</td>";

        if ($role == 'admin' || $row['added_by'] == $user_id) {
            echo "<td><a href='edit_student.php?id=$student_id'>Edit</a> | ";
            if ($role == 'admin') {
                echo "<a href='delete_student.php?id=$student_id'>Delete</a></td>";
            }
        } else {
            echo "<td>No actions available</td>";
        }

        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No student records found.";
}

$conn->close();
?>

<link rel="stylesheet" href="style.css">   
     <div class="back-button">
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</div>
</div>
