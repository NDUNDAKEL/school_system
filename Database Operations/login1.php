<?php
include('connect.php');

$error_message = "";
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $schoolID = filter_input(INPUT_POST, 'schoolID', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Sanitize input
    $schoolID = mysqli_real_escape_string($conn, $schoolID);
    
    // Query to check if the entered credentials exist in the database
    $query = "SELECT * FROM register WHERE school_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $schoolID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Password is correct, redirect to the user page needed.
            session_start();
            $_SESSION['schoolID'] = $schoolID;
            header("Location:../Academics.php");
            exit();
        } else {
            // Password is incorrect
            $error_message = "Sorry, incorrect password. Please try again.";
        }
    } else {
        // User not found
        $error_message = "User not found!";
    }
}

// Display error message to the user
echo $error_message;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->
  
    <style>
       body{
            
        }
        .form{
            display: inline-block;
            height: auto;
            margin: 6%;
            
            padding: 10px;
            background-color: blue;
            border-radius: 7px;
        }
        footer{
            color:blue;
            margin: 0%;
            height: auto;
        }
        button{
            background: orange;
            font-weight: bolder;
            color: white;
            border-radius: 5px;
            width:50px;
            height: 30px;
            border: none;
            cursor: pointer;
            margin:20px
        }
        #reg{
            background: white;
            font-weight: bolder;
            color: black;
            border-radius: 5px;
            width:70px;
            height: 30px;
            border: none;
            cursor: pointer;
            margin:20px
        }
        label{
            color: white;
                margin-top:20px; 
        }
        input{
            width: 100%;
            background-color: white;
            border-radius: 5px;
            border: none;
            height: 30px;
            margin-top:20px; 
        }
        input::placeholder{
            color:red;
            margin-left:10px;
        }
        p{
            cursor: pointer;
        }
        /* .container{
            background-color: #43E6E6;
        } */
        a{
            height: auto;
            width: auto;
            background-color:blue;
            color:white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
        }
        input::placeholder {
            color: red;
            margin-left: 10px;
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
<a href="aboutUs.html">Back to School Page</a>
<center>
    <div class="container">
        <div class="form">
            <form action="login1.php" method="post">
                <img style="border-radius:5px;" src="makuenilogo.png" alt="school logo"><br>
                <label for="schoolID">Enter your school ID</label>
                <input required type="text" name="schoolID" placeholder="Enter your school ID"><br>
                <label for="password">Enter your password</label>
                <div class="password-toggle">
                        <input required type="password" name="password" id="password1" placeholder="Enter password">
                        <span class="toggle-icon" onclick="togglePasswordVisibility1()">
                            <i style="margin-top:100%;" id="eyeIcon1" class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                <button type="submit">Login</button>
                <a id="reg" href="register.php">Register</a>
    </div>
                <p onclick="forgotPassword()" style="color: red;">Forgot password?</p>
            </form>
        </div>
         <div style="color:red; margin-top:10px; font-weight:bolder;">
                <?php if (!empty($error_message)) { ?>
                    <p><?php echo $error_message; ?></p>
                <?php } ?>
            </div>
    </div>
</center>
<footer>
    <center>
        <h2 style="color:green;"><span>Like a tree knowledge grows</span></h2>
        <p>Powered by School Space &copy; 2024</p>
    </center>
</footer>
<script>
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
</script>
</body>
</html>
