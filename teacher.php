<?php
include('Database Operations/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_name = filter_input(INPUT_POST, 'teacher_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $national_id = filter_input(INPUT_POST, 'national_id', FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT);
    
    // Generate a unique token
    //$token = bin2hex(random_bytes(16)); // Generates a 32-character hexadecimal string
    function generateRandomString($length = 8) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Define the characters you want to use
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)]; // Generate random characters
        }
        return $randomString;
    }
    $randomString = generateRandomString(8);
    // Insert data into the database
    $sql = "INSERT INTO teacher (`name`, `national_id`, `email`, `phone_number`, `token`) VALUES ('$teacher_name', '$national_id', '$email', '$phone', '$randomString')";  
    
    if(mysqli_query($conn, $sql)){
        $message="<p>Teacher added successfully</p>";
        $teacher_name="";
        $national_id="";
        $email="";
        $phone="";
    } else {
       $message= "Error: " . mysqli_error($conn);
    }
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
            background: yellow;
            font-weight: bolder;
            color: black;
            border-radius: 5px;
            width:100px;
            height: 30px;
            border: none;
            cursor: pointer;
            margin:20px;
        }
        button:hover{
            background-color:blue;
            color:white;
        }
        label{
            color: white;
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
    <a href="login1.php">Already registered? <span style="color:white">Sign in </span><i class="fas fa-sign-in-alt"></i></a> <!-- Link to login page -->
    <center>
        <div class="container">
            <div class="form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <img  style="border-radius:9px;"src="makuenilogo.png" alt="school logo"><br>
                    <label for="teacher_name">Enter teacher name</label>
                    <input required type="text" name="teacher_name" placeholder="Enter your Teacher name"><br>
                    <label for="national_id">Enter teacher national ID</label>
                    <input required type="number" name="national_id" placeholder="Enter ID"><br>
                    <label for="email">Enter teacher email</label>
                    <input required type="email" name="email" placeholder="Teacher's email address"><br>
                    <label for="phone">Enter teacher phone number</label>
                    <input required type="tel" name="phone" placeholder="Teacher's tel number"><br>
                    <button type="submit">Add Teacher</button>
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
