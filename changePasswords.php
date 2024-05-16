<?php
include('Database Operations/connect.php');

$message = ""; // Initialize message variable

$query = "SELECT * FROM register WHERE school_id = '$id'";
$result = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $schoolID = $row['school_id'];
    $name = $row['name'];
    $oldpasswordS = $row['password'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $oldpassword = filter_input(INPUT_POST, 'oldpassword', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $confirmPassword = $_POST['confirm_password'];

        // Check if the old password matches
        if (!password_verify($oldpassword, $oldpasswordS)) {
            $message = "Incorrect old password";
        } elseif ($password != $confirmPassword) {
            $message = "New Passwords do not match!";
        } elseif (!preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,}$/', $password)) {
            $message = "Use a strong password!";
        } else {
            // Hash the new password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // Update password in the database
            $update_query = "UPDATE register SET password = '$hashedPassword' WHERE school_id = '$schoolID'";
            if (mysqli_query($conn, $update_query)) {
                echo '<script>
                if(confirm("Password changed successfully. Do you want to log out and go to login page?")) {
                    window.location.href = "Database Operations/login1.php"; // Redirect to login page
                } else {
                    alert("You are still logged in.");
                }
            </script>';
            } else {
                $message = "Error updating password";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->
    <style>
        body{
            background-color: aliceblue;
        }
        .form1{
            display: inline-block;
            height: auto;
            width: 150%;
            padding: 10px; 
            background-color: lightgreen;
            border-radius: 7px;
            margin-left:50%;
            margin-top:10%;
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
            width:auto;
            height: auto;
            border: none;
            cursor: pointer;
            margin:20px;
        }
        label{
            color: black;
        }
        input{
            width: 100%;
            background-color: white;
            border-radius: 5px;
            border: none;
            color:blue;
            height: 30px;
        }
        p{
            cursor: pointer;
        }
        .container{
            background-color: aliceblue;
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
    <center>
            <div class="form1">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <img style='border-radius:9px;' src="makuenilogo.png" alt="school logo"><br>
                    <label for="schoolID">Your school ID</label>
                    <input readonly required type="text" value="<?php echo $schoolID ?>" name="schoolID" placeholder="Your school ID"><br>
                    <label for="name">Your name</label>
                    <input readonly required type="text" value="<?php echo $name ?>" name="name" placeholder="Your name"><br>
                    <label for="oldpassword">Enter your current password</label>
                    <div class="password-toggle">
                        <input required type="password" name="oldpassword" id="password" placeholder="Enter your current password">
                        <span class="toggle-icon" onclick="togglePasswordVisibility()">
                            <i id="eyeIcon" class="fas fa-eye"></i>
                        </span>
                    </div>
                    <label for="password">Enter the new password</label>
                    <div class="password-toggle">
                        <input required type="password" name="password" id="password2" placeholder="Enter password">
                        <span class="toggle-icon" onclick="togglePasswordVisibility2()">
                            <i id="eyeIcon2" class="fas fa-eye"></i>
                        </span>
                    </div>
                    <label for="password">Confirm your new password</label>
                    <div class="password-toggle">
                        <input required type="password" name="confirm_password" id="password1" placeholder="Confirm password">
                        <span class="toggle-icon" onclick="togglePasswordVisibility1()">
                            <i id="eyeIcon1" class="fas fa-eye"></i>
                        </span>
                    </div>
                    <button type="submit">Change Password</button>
    </form>
            <div style="color:red; margin-top:10px; font-weight:bolder;">
                <?php echo $message; ?> <!-- Display error message here -->
            </div>
        </div>
    </center>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script> <!-- Font Awesome JS -->
    <script>
        // JavaScript function to toggle password visibility
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
        function togglePasswordVisibility2() {
            var passwordInput2= document.getElementById("password2");
            var eyeIcon2 = document.getElementById("eyeIcon2");
            
            if (passwordInput2.type === "password") {
                passwordInput2.type = "text";
                eyeIcon2.classList.remove("fa-eye");
                eyeIcon2.classList.add("fa-eye-slash");
            } else {
                passwordInput2.type = "password";
                eyeIcon2.classList.remove("fa-eye-slash");
                eyeIcon2.classList.add("fa-eye");
            }
        }
    </script>
</body>
</html>
