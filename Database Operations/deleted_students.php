<?php
include("connect.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$message = ""; // Initialize message variable

if (isset($_SESSION['id_to_delete'])) {
    $id = $_SESSION['id_to_delete']; // Retrieve the student's ID from session

    // Fetch student details
    $query = "SELECT * FROM student WHERE student_id = '$id'";
    $result1 = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result1)) {
        $name = $row['name'];
    } else {
        $message = "Student not found.";
    }
} else {
    $message = "Student ID to delete not found in session.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $reason = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_SPECIAL_CHARS);
    $schoolID = filter_input(INPUT_POST, 'schoolID', FILTER_SANITIZE_SPECIAL_CHARS);

    // Insert the student details into the deleted_students table
    $query2 = "INSERT INTO deleted_students (`student_id`,`name`,`reason_for_deletion`,`deleted_at`) VALUES ('$schoolID','$name','$reason',NOW())";

    try {
        mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

        // Delete related records first
        $queries = [
            "DELETE FROM subjects_taken WHERE student_id = '$id'",
            "DELETE FROM student_mean WHERE student_id = '$id'",
            "DELETE FROM parent_login WHERE parent_id = '$id'",
            "DELETE FROM parents WHERE student_id = '$id'",
            "DELETE FROM student_coments WHERE student_id = '$id'"
      
        ];

        foreach ($queries as $query) {
            mysqli_query($conn, $query);
        }

        // Delete from student table
        $query1 = "DELETE FROM student WHERE student_id = '$id'";
        mysqli_query($conn, $query1);

        // Insert into deleted_students table
        mysqli_query($conn, $query2);

        mysqli_commit($conn);

        $message = '<p style="color:green">Successfully Deleted from Students Database!</p>';
        session_destroy();
    } catch (mysqli_sql_exception $e) {
        mysqli_rollback($conn);
        $message = "Error deleting student: " . $e->getMessage();
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: aliceblue;
        }
        .form {
            display: inline-block;
            height: auto;
            width: auto;
            margin: 6%;
            padding: 10px;
            background-color: orange;
            border-radius: 7px;
        }
        footer {
            color: blue;
            margin: 0%;
            height: auto;
        }
        button {
            background: blue;
            font-weight: bolder;
            color: white;
            border-radius: 5px;
            width: 100px;
            height: 30px;
            border: none;
            cursor: pointer;
            margin: 20px;
        }
        label {
            color: green;
        }
        input {
            width: 100%;
            background-color: white;
            border-radius: 5px;
            border: none;
            height: 30px;
        }
        .container {
            background-color: aliceblue;
        }
        a {
            background-color: orange;
            color: blue;
            text-decoration: none;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <a href="EditStudents.php"> <span style="color:Black; height:auto; width:auto; background-color:green;">Go Back</span><i class="fas fa-sign-in-alt"></i></a>

    <center>
        <div class="container">
            <div class="form">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <img src="makuenilogo.png" alt="school logo"><br>
                    <label for="schoolID">Student ID</label>
                    <input required type="text" name="schoolID" value="<?php echo $id; ?>"><br>
                    <label for="name">Student name</label>
                    <input required type="text" name="name" value="<?php echo $name; ?>"><br><br>
                    <textarea name="reason" rows="5" cols="50" placeholder="Enter the reason for removing the student <?php echo $id; ?>"></textarea>
                    <br>
                    <a href="EditStudents.php">Back to view students</a><br>
                    <button name="delete">Delete</button><br>
                    <a style='color:green' href="deletedshow.php">View Deleted students</a><br>
                </form>
            </div>
            <div style="color:red; margin-top:10px; font-weight:bolder;">
                <?php echo $message; ?>
            </div>
        </div>
    </center>
    <footer>
        <center>
            <h2 style="color:green;"><span>Like a tree knowledge grows</span></h2>
            <p>Powered by School Space &copy; 2024</p>
        </center>
    </footer>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</html>
