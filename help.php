<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If the user is not logged in, redirect to login page
    header("Location: userlogin.php");

}else{
$username = $_SESSION['username'];
}

// Database connection parameters
$servername = "localhost";
$dbusername = "root";
$dbpassword = "root";
$dbname = "projectdb";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize the username to prevent SQL injection
$username = $conn->real_escape_string($username);

// Prepare and execute the query to get the user's profile data
$sql = "SELECT FirstName, LastName, Program, ProjectTitle FROM student WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    // Fetch the user's data
    $user = $result->fetch_assoc();
} else {
    // Handle case where the user is not found
    $userName1 = "User Not found";
    die("User not found.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="Myprofile.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>My Profile</h1>
        <div class="profile">
            <div class="profile-image">
                <img src="images/student_m.png" alt="User Profile Picture">
            </div>
            <div class="profile-details">
                <h2><?php echo htmlspecialchars($username); ?></h2>
                <p>First Name: <?php echo htmlspecialchars($user['FirstName']); ?></p>
                <p>Last Name: <?php echo htmlspecialchars($user['LastName']); ?></p>
                <p>Program: <?php echo htmlspecialchars($user['Program']); ?></p>
                <p>Project Title: <?php echo htmlspecialchars($user['ProjectTitle']); ?></p>
            </div>
        </div>
        <a href="editmyprofile.html" id="editProfileLink">Edit Profile</a>
    </div>
</body>
</html>