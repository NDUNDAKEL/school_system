

<?php
include("connect.php");
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if(isset($_SESSION['id_to_edit'])){
    $id_to_edit=$_SESSION['id_to_edit'];
    $query_edit = "SELECT * FROM student WHERE student_id = '$id_to_edit'";
    $result_edit = mysqli_query($conn,$query_edit);

    if($row=mysqli_fetch_assoc($result_edit)){
        $student_id=$row['student_id'];
        $email=$row['email'];
        $name=$row['name'];
        $gender=$row['gender'];
        $indexnumber=$row['indexnumber'];
        $classroomId=$row['classroom_id'];
        $form=$row['form'];
        $dormitory=$row['dormitory'];
        $DOB=$row['DOB'];
    }
$query_dormitory = "SELECT * FROM dormitory";
$result_dormitory = mysqli_query($conn, $query_dormitory);
$query_classroom = "SELECT * FROM classroom";
$result_classroom = mysqli_query($conn, $query_classroom);

$query_form = "SELECT * FROM form";
$result_form = mysqli_query($conn, $query_form);

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form inputs
    $name1 = filter_input(INPUT_POST, "student_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $email1 = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $gender1 = $_POST["gender"];
    $indexnumber1 = $_POST["index"];
    $classroom1 = $_POST["classroom"];
    $form_category1 = $_POST["form_category"];
    $dormitory1 = $_POST["dormitory"];
    $DOB1 = $_POST["DOB"];

    // Update student information
    $sql = "UPDATE student SET email='$email1', name='$name1', gender='$gender1', indexnumber='$indexnumber1', classroom_id='$classroom1', dormitory='$dormitory1',form='$form_category1', DOB='$DOB1' WHERE student_id ='$student_id'";

    if (mysqli_query($conn, $sql)) {
        $message = "<p style='color:green;'>Student edited successfully</p>";
        $_SESSION = array();
        session_destroy();
        header("Location:EditStudents.php");
    } else {
        $message = "<p style='color:red;'>Error editing the student.</p>";
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
    <title>Edit Student</title>
    <style>
      body{
            background-color: aliceblue;
        }
        .form{
            display: inline-block;
            height: auto;
            color: white;
            width: 40%;
            height:auto;
            margin: 6%;
            padding: 10px; 
            background-color:orange;
            border-radius: 7px;
        }
        footer{
            color:rgb(255, 0, 191);
            margin: 0%;
            height: auto;
        }
        button{
            background: blue;
            font-weight: bolder;
            color: white;
            border-radius: 5px;
            width:auto;
            height: 30px;
            border: none;
            cursor: pointer;
            margin:20px;
        }
        #view{
            background-color:green;
        }
        label{
            color: white;
        }
        input{
            width: 100%;
            height: 30px;
            border: none;
            background-color: aquamarine;
            border-radius: 5px;
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
            background-color:blue;
            color:white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
        }
        label{
            color:white;
            font-weight:bolder;
        }
        #message{
            padding-top:2px;
            background:white;
            align-items:center;
        }
        #gender>label{
            color:blue;
        }
        #gender>input{
            height:20px;
            cursor:pointer;
        }
        #gender{
            display:flex;
            width:20%;
            align-items:center;
            margin-right:40%;
            
        }
        #heading{
             display:block;
            
        }
        #heading>img{
            height:70px;
         
        
        }
    </style>
</head>
<body>
    <a href="aboutUs.html">Back to School Page</a>
    <center>
        <div id='heading'>
<h1 style="color:green;">Makueni Boys High School Edit Students Details Page</h1>

    </div>
    <hr>
    </center>
    <center>
        <div class="container">
            <div class="form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <!-- Form fields with PHP values -->
                    <img src="../makuenilogo.png" alt="school logo"><br>
                    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                    <label for="student_name">Enter the student name</label>
                    <input required type="text" name="student_name" value="<?php echo $name; ?>" placeholder="Enter the student name"><br>
                    <label for="email">Enter your email</label>
                    <input required type="email" name="email" value="<?php echo $email; ?>" placeholder="Enter your email"><br>
                    <label>Choose gender:</label>
                    <div id='gender'>
                    <input type="radio" id="male" name="gender" value="male" <?php if($gender == 'male') echo "checked"; ?>>
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="female" <?php if($gender == 'female') echo "checked"; ?>>
                    <label for="female">Female</label>
                    <input type="radio" id="other" name="gender" value="other" <?php if($gender == 'other') echo "checked"; ?>>
                    <label for="other">Other</label><br>
    </div>
                    <label for="index">Enter your KCPE index number</label>
                    <input required type="number" name="index" value="<?php echo $indexnumber; ?>" placeholder="Enter your KCPE index number"><br>
                    <!-- Form Category Selection -->
                    <label for="form_category">Select Form Category:</label><br>
                    <select id="form_category" name="form_category">
                        <?php 
                        while ($row_form = mysqli_fetch_assoc($result_form)) { ?>
                              <option value="<?php echo $row_form['form_name']; ?>" <?php if($form == $row_form['form_name']) echo "selected"; ?>><?php echo $row_form['form_name']; ?></option>
                        <?php } ?>
                    </select><br>
                    <!-- Classroom Selection -->
                    <label for="classroom">Select Classroom:</label><br>
                    <select id="classroom" name="classroom">
                        <?php while ($row_class = mysqli_fetch_assoc($result_classroom)) { ?>
                            <option value="<?php echo $row_class['classroom_id']; ?>" <?php if($classroomId == $row_class['classroom_id']) echo "selected"; ?>><?php echo $row_class['classroom_id']; ?></option>
                        <?php } ?>
                    </select><br>
                    <!-- Dormitory Selection -->
                    <label for="dormitory">Select Dormitory:</label><br>
                    <select id="dormitory" name="dormitory">
                        <?php while ($row_dormitory = mysqli_fetch_assoc($result_dormitory)) { ?>
                            <option value="<?php echo $row_dormitory['dormitory_id']; ?>" <?php if($dormitory == $row_dormitory['dormitory_id']) echo "selected"; ?>><?php echo $row_dormitory['dormitory_id']; ?></option>
                        <?php } ?>
                    </select><br>
                    <label for="DOB">Enter the date of birth</label>
                    <input required type="date" name="DOB" value="<?php echo $DOB; ?>" placeholder="Enter the student's DOB"><br>
                    <button type="submit" name="submit">Update Student</button>
                    <button onclick="window.location.href='EditStudents.php'" type="button">View Students</button>
                </form>
                <div id="message">
                    <?php echo $message; ?>
                </div>
            </div>
        </div>
    </center>
    <footer>
        <center>
            <h2>Like a tree knowledge grows</h2>
            <p>Powered by School Space &copy 2024</p>
        </center>
    </footer>
</body>
</html>
