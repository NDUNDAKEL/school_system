<?php
include("Database Operations/connect.php");

//using php mailer

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// $message = ""; // Initialize message variable
$teacher_id = filter_input(INPUT_POST, 'teacher_id', FILTER_SANITIZE_SPECIAL_CHARS);
$classroom = $_POST['classroom'];
$query = "SELECT * FROM teacher WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($conn, $query);
if(mysqli_fetch_assoc($result)>0){
if ($_SERVER["REQUEST_METHOD"] == "POST") {

   
    $sql="INSERT INTO class_teachers (`class_id`,`classteacher_id`) VALUES ('$classroom','$teacher_id')";
    try {
        mysqli_query($conn, $sql);
        echo "<script> alert('Successfully Registered!')</script>";
    } catch (mysqli_sql_exception $e) {
        echo "<script> alert('Error adding Class teacher')</script>";
    }
}

}else{
    echo "<script> alert('Class teacher ID not found. You have to be a registered teacher to have a classteacher account')</script>";
}
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
            background: black;
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
            color: white;
        }
        input{
            width: 100%;
            background-color: lightgreen;
          
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
            /* background-color:orange; */
            color: yellow;
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
<a href="teacher_account_login.php">Already registered? <span style="color:white">Sign in </span><i class="fas fa-sign-in-alt"></i></a>

    <center>
        <div class="container">
            <div class="form">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <img  style="border-radius:9px;"src="makuenilogo.png" alt="school logo"><br>
                    <label for="teacher_id">Enter Teacher ID</label>
                    <input required type="text" name="teacher_id" placeholder="Enter Teacher ID"><br>
                    <label for="classroom">Select Class</label><br>
                    <select id="classroom" name="classroom">
        <?php  
          $query_classroom = "SELECT * FROM classroom";
          $result_classroom = mysqli_query($conn, $query_classroom);     
while ($row_class = mysqli_fetch_assoc($result_classroom)) {
    echo "<option value='" . $row_class['classroom_id'] . "'>" . $row_class['classroom_id'] . "</option>";
}
            ?>
        </select><br>
                  
                    <button type="submit">Add Class Teacher</button>
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

</html>
