<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lms_admin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $exam_name = $_POST['exam_name'];
    $exam_date = $_POST['exam_date'];

    $sql = "INSERT INTO exams (name, date) VALUES ('$exam_name', '$exam_date')";

    if ($conn->query($sql) === TRUE) {
        echo "New exam session added successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT id, name, date FROM exams";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Exams - LMS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Manage Exams</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.html">Home</a></li>
                <li><a href="manage_teachers.html">Manage Teachers</a></li>
                <li><a href="manage_admissions.html">Manage Admissions</a></li>
                <li><a href="manage_exams.html">Manage Exams</a></li>
                <li><a href="send_notifications.html">Send Notifications</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>Add New Exam Session</h2>
            <form action="manage_exams.php" method="post">
                <label for="exam_name">Exam Name:</label>
                <input type="text" id="exam_name" name="exam_name" required><br>
                <label for="exam_date">Exam Date:</label>
                <input type="date" id="exam_date" name="exam_date" required><br>
                <button type="submit">Add Exam</button>
            </form>
        </section>
        <section>
            <h2>Existing Exam Sessions</h2>
            <table>
                <tr>
                    <th>Exam Name</th>
                    <th>Exam Date</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>No exams scheduled</td></tr>";
                }
                $conn->close();
                ?>
            </table>
        </section>
    </main>
</body>
</html>
