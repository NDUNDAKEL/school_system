<?php
include("connect.php");
$name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_SPECIAL_CHARS);
$reason=filter_input(INPUT_POST,'reason',FILTER_SANITIZE_SPECIAL_CHARS);
$schoolID=filter_input(INPUT_POST,'schoolID',FILTER_SANITIZE_SPECIAL_CHARS);
$message = ""; // Initialize message variable
    session_start();
    if(isset($_SESSION['id_to_delete'])) {
        $id = $_SESSION['id_to_delete']; // Retrieve the student's ID from session
        // You can use $id here as needed
        $query="SELECT * FROM student WHERE student_id = '$id'";
        $query2="INSERT INTO `deleted_students`(`student_id`,`name`,`reason_for_deletion`,`deleted_at`) VALUES ('$schoolID','$name','$reason',NOW())";

        $result1=mysqli_query($conn,$query);
        if($row = mysqli_fetch_assoc($result1)){
            $name=$row['name'];
        }
    } else {
        // Handle the case where the session variable is not set (optional)
        $message="Student ID to delete not found in session.";
    }
if(isset($_POST['delete'])){
     $query1 = "DELETE FROM student WHERE student_id = '$id'";
try {
    mysqli_query($conn, $query1);
    mysqli_query($conn,$query2);
    $id="";
    $name="";
    session_destroy();
    $message = '<p style="color:green">Successfully Deleted from Students Database!</p>';
    session_destroy();
} catch (mysqli_sql_exception $e) {
    $message = "Error Deleting Student";

}
}
mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->
    <style>
        body{
            background-color: aliceblue;
        }
        .form{
            display: inline-block;
            height: auto;
            width: auto;
            margin: 6%;
            padding: 10px; 
            background-color: orange;
            border-radius: 7px;
        }
        footer{
            color:blue;
            margin: 0%;
            height: auto;
        }
        button{
            background: blue;
            font-weight: bolder;
            color: white;
            border-radius: 5px;
            width:100px;
            height: 30px;
            border: none;
            cursor: pointer;
            margin:20px;
        }
        label{
            color: green;
        }
        input{
            width: 100%;
            background-color: white;
            border-radius: 5px;
            border: none;
            height: 30px;
        }
        p{
            cursor: pointer;
        }
        .container{
            background-color: aliceblue;
        }
        a{
            height: auto;
            width: auto;
            background-color:orange;
            color: blue;
            text-decoration: none;
            border: none;
            border-radius: 5px;
        }
        .password-toggle {
            position: relative;
            display:flex;
        }

        .password-toggle input[type="password"] {
            padding-right: 40px;
        }

        .password-toggle .toggle-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <a href="login1.php">Already registered? <span style="color:white">Sign in </span><i class="fas fa-sign-in-alt"></i></a> <!-- Link to login page -->
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
                    <a href="EditStudents.php">Back to view students </a>
                    <button name="delete">Delete</button>
                </form>
            </div>
            <div style="color:red; margin-top:10px; font-weight:bolder;">
                <?php echo $message; ?> <!-- Display error message here -->
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script> <!-- Font Awesome JS -->
<!-- <script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var eyeIcon = document.getElementById("eyeIcon");
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
    function togglePasswordVisibility1() {
        var passwordInput1 = document.getElementById("password1");
        var eyeIcon1 = document.getElementById("eyeIcon1");
        
        if (passwordInput1.type === "password") {
            passwordInput1.type = "text";
            eyeIcon1.classList.remove("fa-eye");
            eyeIcon1.classList.add("fa-eye-slash");
        } else {
            passwordInput1.type = "password";
            eyeIcon1.classList.remove("fa-eye-slash");
            eyeIcon1.classList.add("fa-eye");
        }
    }
</script> -->
</html>







