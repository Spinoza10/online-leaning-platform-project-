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
    $action = $_POST['action'];
    $status = $action === 'open' ? 'open' : 'closed';
    $sql = "UPDATE admissions SET status='$status' WHERE id=1"; // Assuming a single admission period

    if ($conn->query($sql) === TRUE) {
        echo "Admission status updated successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT status FROM admissions WHERE id=1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$admission_status = $row['status'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admissions - LMS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Manage Admissions</h1>
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
            <h2>Admission Status</h2>
            <p>Current status: <?php echo $admission_status; ?></p>
            <form action="manage_admissions.php" method="post">
                <button type="submit" name="action" value="open">Open Admissions</button>
                <button type="submit" name="action" value="close">Close Admissions</button>
            </form>
        </section>
    </main>
</body>
</html>
