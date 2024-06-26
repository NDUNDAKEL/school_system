<?php
include("connect.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (isset($_SESSION['student_idP'])) {
    $student_id = $_SESSION['student_idP'];
} else {
    echo 'No session';
    exit;
}

if (isset($_POST['reg'])) {
    $parentname = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, 'ID', FILTER_SANITIZE_SPECIAL_CHARS);

    function generateRandomString($length = 8) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $randomString = generateRandomString(8);

    // Check if the parent already exists
    $getparent = "SELECT * FROM parents WHERE parent_id = '$student_id'";
    $parent = mysqli_query($conn, $getparent);

    if (mysqli_num_rows($parent) > 0) {
        echo "<script>alert('Parent already exists with ID: {$student_id}')</script>";
    } else {
        // Insert new parent
        $insert = "INSERT INTO parents (parent_id, student_id, name, email, phone_number, adress, nationalID, token) 
                   VALUES ('$student_id','$student_id', '$parentname', '$email', '$phone', '$address', '$id', '$randomString')";
        $result = mysqli_query($conn, $insert);

        if ($result) {
            echo "<script>alert('Added Parent Successfully')</script>";
            $message = 'Added Parent Successfully with token ' . $randomString;
        } else {
            echo "<script>alert('Error adding parent')</script>";
        }
    }
}
mysqli_close($conn);
$message = ""; // Initialize message variable
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
<a href="student.php">Back to student Register</a> <!-- Link to login page -->

    <center>
    <h1>Student added successfully with ID:<span style='color:green;'> <?php echo $student_id; ?></span></h1>
        <div class="container">
            <div class="form">
                <form action="parent_info.php" method="post">
                    <img style='border-radius:9px;' src="makuenilogo.png" alt="school logo"><br>
                    <label for="student_id">Child ID</label>
                    <input required type="number" value='<?php echo $student_id; ?>' name="student_id" placeholder="Enter Child school ID"><br>
                    <label for="name">Enter your name</label>
                    <input required type="text" name="name" placeholder="Parent name"><br>
                    <label for="name">Enter your email</label>
                    <input required type="email" name="email" placeholder="Parent email"><br>
                    <label for="phone">Enter your phone number</label>
                    <input required type="tel" name="phone" placeholder="Phone number"><br>
                    <label for="address">Enter your address</label>
                    <input required type="text" name="address" placeholder="Address"><br>
                    <label for="national ID">Parent ID</label>
                    <input required type="number" name="ID" placeholder="Parent National ID"><br>
                  <button name='reg' type='submit'>Submit</button>
                  <a href='viewparents.php'>View Parents</a>
                
        </div>
        <?php if($message){
            echo "<p>{$message}</p>";
        } ?>
    </center>
    <footer>
        <center>
            <h2 style="color:green;"><span>Like a tree knowledge grows</span></h2>
            <p>Powered by School Space &copy; 2024</p>
        </center>
    </footer>
</body>

<script>
    
</script>
</html>







