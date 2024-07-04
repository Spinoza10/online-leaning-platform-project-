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
    $user_id = $_POST['user_id'];
    $message = $_POST['message'];

    // Fetch user email
    $sql = "SELECT email FROM users WHERE id='$user_id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $user_email = $row['email'];

    // Send email
    $subject = "Notification from LMS";
    $headers = "From: admin@lms.com";

    if (mail($user_email, $subject, $message, $headers)) {
        // Insert into notifications table
        $sql = "INSERT INTO notifications (user_id, message) VALUES ('$user_id', '$message')";

        if ($conn->query($sql) === TRUE) {
            echo "Notification sent successfully";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Failed to send email";
    }
}

$sql = "SELECT id, username, email FROM users WHERE role='student'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Notifications - LMS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Send Notifications</h1>
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
            <h2>Send Notification</h2>
            <form action="send_notifications.php" method="post">
                <label for="user_id">Select Student:</label>
                <select id="user_id" name="user_id" required>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['username'] . " (" . $row['email'] . ")</option>";
                        }
                    } else {
                        echo "<option value=''>No students found</option>";
                    }
                    ?>
                </select><br>
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea><br>
                <button type="submit">Send Notification</button>
            </form>
        </section>
    </main>
</body>
</html>
