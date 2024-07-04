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
    $user_id = $_POST['user_id'];
    
    if ($action === 'approve') {
        $sql = "UPDATE users SET status='approved' WHERE id='$user_id'";
    } elseif ($action === 'reject') {
        $sql = "UPDATE users SET status='rejected' WHERE id='$user_id'";
    }
    
    if ($conn->query($sql) === TRUE) {
        echo "Action completed successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT id, username, email, phone, status FROM users WHERE role='teacher' AND status='pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Teachers - LMS</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Manage Teachers</h1>
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
            <h2>Teacher Requests</h2>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>
                            <form action='manage_teachers.php' method='post'>
                                <input type='hidden' name='user_id' value='" . $row['id'] . "'>
                                <button type='submit' name='action' value='approve'>Approve</button>
                                <button type='submit' name='action' value='reject'>Reject</button>
                            </form>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No pending requests</td></tr>";
                }
                $conn->close();
                ?>
            </table>
        </section>
    </main>
</body>
</html>
