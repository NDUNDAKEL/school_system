<?php
include("Database Operations/connect.php");
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$message = '';

if (isset($_SESSION['teacher_id_to_edit'])) {
    $id_to_edit = $_SESSION['teacher_id_to_edit'];
    $query_edit = "SELECT * FROM teacher WHERE teacher_id = '$id_to_edit'";
    $result_edit = mysqli_query($conn, $query_edit);

    if ($row = mysqli_fetch_assoc($result_edit)) {
        $teacher_idS = $row['teacher_id'];
        $nameS = $row['name'];
        $nationalIDS = $row['national_id'];
        $emailS = $row['email'];
        $phone_numberS = $row['phone_number'];
        //S means the values from session which will be the value in the input box before we edit .
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize form inputs
        $teacher_id = filter_input(INPUT_POST, "teacher_id", FILTER_SANITIZE_NUMBER_INT);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $nationalID = filter_input(INPUT_POST, "nationalID", FILTER_SANITIZE_NUMBER_INT);
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
        $phone_number = filter_input(INPUT_POST, "phone_number", FILTER_SANITIZE_NUMBER_INT);

        // Ensure required fields are not empty
        if (!empty($teacher_idS) && !empty($email) && !empty($nationalID) && !empty($name) && !empty($phone_number)) {
            // Update teacher information
            $sql = "UPDATE teacher SET name='$name', email='$email', phone_number='$phone_number', national_id='$nationalID' WHERE teacher_id='$teacher_idS'";

            if (mysqli_query($conn, $sql)) {
                $message = "<script>alert('Teacher edited successfully')</script>";
                
                // Clear session data and destroy session
                $_SESSION = array();
                session_destroy();
            } else {
                $message = "<p style='color:red;'>Error editing the Teacher: " . mysqli_error($conn) . "</p>";
            }
        } else {
            $message = "<p style='color:red;'>All fields are required.</p>";
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
    <style>
        body {
            background-color: aliceblue;
        }
        .form {
            display: inline-block;
            color: white;
            width: 40%;
            margin: 6%;
            padding: 10px;
            background-color: orange;
            border-radius: 7px;
        }
        footer {
            color: rgb(255, 0, 191);
            margin: 0%;
        }
        button {
            background: blue;
            font-weight: bolder;
            color: white;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin: 20px;
        }
        #view {
            background-color: green;
        }
        label {
            color: white;
            font-weight: bolder;
        }
        input {
            width: 100%;
            height: 30px;
            border: none;
            background-color: aquamarine;
            border-radius: 5px;
        }
        .container {
            background-color: aliceblue;
        }
        a {
            background-color: blue;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
        }
        #message {
            padding-top: 2px;
            background: white;
            align-items: center;
        }
        #gender > label {
            color: blue;
        }
        #gender > input {
            height: 20px;
            cursor: pointer;
        }
        #gender {
            display: flex;
            width: 20%;
            align-items: center;
            margin-right: 40%;
        }
        #heading {
            display: block;
        }
        #heading > img {
            height: 70px;
        }
    </style>
</head>
<body>
    <a href="aboutUs.html">Back to School Page</a>
    <center>
        <div id='heading'>
            <h1 style="color: green;">Makueni Boys High School Edit Teacher Details Page</h1>
        </div>
        <hr>
    </center>
    <center>
        <div class="container">
            <div class="form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <!-- Form fields with PHP values -->
                    <img style='border-radius: 7px' src="makuenilogo.png" alt="school logo"><br>
                    <input type="text" disabled name="teacher_id" value="<?php echo htmlspecialchars($teacher_idS); ?>">
                    <label for="name">Enter the Teacher name</label>
                    <input required type="text" name="name" value="<?php echo htmlspecialchars($nameS); ?>" placeholder="Enter the Teacher name"><br>
                    <label for="email">Enter email</label>
                    <input required type="email" name="email" value="<?php echo htmlspecialchars($emailS); ?>" placeholder="Enter email"><br>
                    <label for="nationalID">Enter National ID</label>
                    <input required type="number" name="nationalID" value="<?php echo htmlspecialchars($nationalIDS); ?>" placeholder="Enter National ID"><br>
                    <label for="phone_number">Enter Phone number</label>
                    <input required type="number" name="phone_number" value="<?php echo htmlspecialchars($phone_numberS); ?>" placeholder="Enter Phone Number"><br>
                    <button type="submit" name="submit">Update Teacher</button>
                    <button onclick="window.location.href='showTeachers.php'" type="button">View Teachers</button>
                </form>
                <div id="message">
                    <?php echo $message; ?>
                </div>
            </div>
        </div>
    </center>
    <footer>
        <center>
            <h2>Like a tree, knowledge grows</h2>
            <p>Powered by School Space &copy; 2024</p>
        </center>
    </footer>
</body>
</html>
