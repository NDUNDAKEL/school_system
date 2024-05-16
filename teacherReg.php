<?php
include("Database Operations/connect.php");

//using php mailer

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// $message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_id = filter_input(INPUT_POST, 'teacher_id', FILTER_SANITIZE_SPECIAL_CHARS);
    $teacher_token = filter_input(INPUT_POST, 'teacher_token', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $confirmPassword = $_POST['confirm_password'];

    $query = "SELECT * FROM teacher WHERE teacher_id = '$teacher_id'";
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        $message = "<p style='color:red'>You have to be a registered teacher to register for an account!</p>
                    <p>Kindly reach out to the school admin in case of problems</p>";
    } else {
        $row = mysqli_fetch_assoc($result);
        $db_token = $row['token'];

        if ($password != $confirmPassword) {
            $message = "Passwords do not match!";
        } elseif (!preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,}$/', $password)) {
            $message = "Use a strong password!";
        } elseif ($teacher_token != $db_token) {
            $message = "Tokens do not match!";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Proceed to save data to the database
            $sql = "INSERT INTO teacher_login (`teacher_id`, `password`, `token`) VALUES ('$teacher_id','$hashedPassword','$teacher_token')";
            try {
                mysqli_query($conn, $sql);
                $message = '<p style="color:green">Successfully Registered!</p>';
            } catch (mysqli_sql_exception $e) {
                $message = "Error registering";
            }
        }
    }
    mysqli_close($conn);
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
            background-color: green;
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
                    <label for="teacher_id">Enter your Teacher ID</label>
                    <input required type="text" name="teacher_id" placeholder="Enter your Teacher ID"><br>
                    <label for="teacher_token">Enter your Teacher token</label>
                    <input required type="text" name="teacher_token" placeholder="Enter your teacher token"><br>
                    <label for="password">Enter your password</label>
                    <div class="password-toggle">
                        <input required type="password" name="password" id="password" placeholder="Enter password">
                        <span class="toggle-icon" onclick="togglePasswordVisibility()">
                            <i id="eyeIcon" class="fas fa-eye"></i>
                        </span>
                    </div>
                    <label for="password">Confirm your password</label>
                    <div class="password-toggle">
                        <input required type="password" name="confirm_password" id="password1" placeholder="Confirm password">
                        <span class="toggle-icon" onclick="togglePasswordVisibility1()">
                            <i id="eyeIcon1" class="fas fa-eye"></i>
                        </span>
                    </div>
                    <a href="login1.php">Already registered? <span style="color:blue">Sign in </span><i class="fas fa-sign-in-alt"></i></a> <!-- Link to login page --><br>
                    <button type="submit">Register</button>
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
<script>
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
</script>
</html>
