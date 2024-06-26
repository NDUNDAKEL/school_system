<?php
include("connect.php");
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();
$query_classroom = "SELECT * FROM classroom";
$result_classroom = mysqli_query($conn, $query_classroom);

$query_dormitory = "SELECT * FROM dormitory";
$result_dormitory = mysqli_query($conn, $query_dormitory);

$query_form = "SELECT * FROM form";
$result_form = mysqli_query($conn, $query_form);

//fetch form options
$formOptions = "SELECT * FROM form";
$resultsform = mysqli_query($conn, $formOptions);
// Function to update dormitory capacity
function updateDormitoryCapacity($dormitory_id, $change) {
    global $conn;
    $sql = "UPDATE Dormitory SET capacity = capacity + $change WHERE dorm_id = '$dormitory_id'";
    mysqli_query($conn, $sql);
}

$student_id = filter_input(INPUT_POST, "student_id", FILTER_SANITIZE_SPECIAL_CHARS);
$student_name = filter_input(INPUT_POST, "student_name", FILTER_SANITIZE_SPECIAL_CHARS);
$classroom = filter_input(INPUT_POST, "classroom", FILTER_SANITIZE_SPECIAL_CHARS);
$dormitory = filter_input(INPUT_POST, "dormitory", FILTER_SANITIZE_SPECIAL_CHARS);
$index = filter_input(INPUT_POST, "index", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$DOB = $_POST['DOB'];
$form_category=$_POST['form_category'];
$gender=$_POST['gender'];
$message = "";
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

// Fetch student with the entered index number
$query = "SELECT * FROM student WHERE indexnumber = '$index'";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $message = "<p style='color:red;'>The student is already registered with admission number: {$row['student_id']}</p>";
} elseif 
(!empty($student_name) && !empty($form_category)   && !empty($classroom)  && !empty($gender)  && !empty($index) && !empty($dormitory) && !empty($DOB) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // Add student
    $sql = "INSERT INTO student (`name`, `form`,`indexnumber`, `email`, `gender`, `classroom_id`, `dormitory`, `date_admitted`, `DOB`, `token`) VALUES ('$student_name', '$form_category', '$index', '$email', '$gender','$classroom', '$dormitory', NOW(), '$DOB','$randomString')";
    if (mysqli_query($conn, $sql)) {
        // Update classroom capacity when a student is added
        // updateClassroomCapacity($classroom, 1);
        
     ;
        $query1 = "SELECT * FROM student WHERE indexnumber = '$index'";
        $result1 = mysqli_query($conn, $query1);
        if(mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $studentId=$row1['student_id'];

        }
        $_SESSION['student_idP']=$row1['student_id'];
        if(isset($_SESSION['student_idP'])){
        header('Location:parent_info.php');
        }
        // Update dormitory capacity when a student is added
        // updateDormitoryCapacity($dormitory, 1);
        $message = "<p style='color:green;'>Student added successfully with a school ID of :{$studentId}</p>";
    } else {
        $message = "<p style='color:red;'>Error adding the student.</p>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        
    </style>
</head>
<body>
    <a href="admin.php">Back to Admin Page</a>
   
    <center>
        <div class="container">
            <div class="form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <img src="../makuenilogo.png" style="border-radius:9px;" alt="school logo"><br>
                    <label for="Student_name">Enter the student name</label>
                    <input required type="text" name="student_name" placeholder="Enter the student name"><br>
                    <label for="email">Enter your email</label>
                    <input required type="email" name="email" placeholder="Enter your email"><br>
                <label style='color:green;'> Choose gender</label>
                    <div id="gender">
                    <label for="male">Male</label>
                    <input type="radio" id="male" name="gender" value="male">
                        <label for="female">Female</label>
                        <input type="radio" id="female" name="gender" value="female">
                        <label for="other">Other</label>
                        <input type="radio" id="other" name="gender" value="other">
    </div>
                    <label for="kcpe ">Enter your kcpe index number</label>
                    <input required type="number" name="index" placeholder="Enter your kcpe index number"><br>
                     <!-- Form Category Selection -->
        <label for="form_category" style="color:red;" >Select Form Category:</label><br>
        <select id="form_category" name="form_category">
        <?php
while ($row_form= mysqli_fetch_assoc($result_form)) {
    echo "<option value='" . $row_form['form_name'] . "'>" . $row_form['form_name'] . "</option>";
}
?>
        </select><br>
        
        <!-- Classroom Selection -->
        <label for="classroom"style="color:blue;" >Select Classroom:</label><br>
        <select id="classroom" name="classroom">
        <?php       
while ($row_class = mysqli_fetch_assoc($result_classroom)) {
    echo "<option value='" . $row_class['classroom_id'] . "'>" . $row_class['classroom_id'] . "</option>";
}
            ?>
            
        </select><br>
        
        <!-- Dormitory Selection -->
        <label for="dormitory"style="color:red;" >Select Dormitory:</label><br>
        <select id="dormitory" name="dormitory">
        <?php
while ($row_dormitory = mysqli_fetch_assoc($result_dormitory)) {
    echo "<option value='" . $row_dormitory['dormitory_id'] . "'>" . $row_dormitory['dormitory_id'] . "</option>";
}
?>
        </select><br>
                    <label for="DOB">Enter the date of birth</label>
                    <input required type="date" name="DOB" placeholder="Enter the student's DOB" min='2001-01-01' max="2008-12-31"><br>

                    <button type="submit" name="submit">Add Student</button>
                    <button onclick="window.location.href='EditStudents.php'" id="view" type="button" name="View">View Students</button>
 </form>
 <div id='message'>
            <?php
                echo $message;
            ?>
            </div>
            </div>
           
    </center>
<footer>
    <center>
        <h2 style="color:green;"><span>Like a tree knowledge grows</span></h2>
        <p>Powered by School Space &copy 2024</p>
    </center>
</footer>
</div>
<!-- <script>
    // JavaScript to populate classroom dropdown based on form category selection
    document.addEventListener('DOMContentLoaded', function() {
        var formCategory = document.getElementById('form_category').value;
        updateClassroomOptions(formCategory);
    });

    document.getElementById('form_category').addEventListener('change', function() {
        var formCategory = this.value;
        updateClassroomOptions(formCategory);
    });

    function updateClassroomOptions(formCategory) {
        var classroomDropdown = document.getElementById('classroom');
        classroomDropdown.innerHTML = ''; // Clear existing options
            
        // Define options based on form category
        var classOptions = {
            '1': ['1W', '1E', '1C', '1N', '1S'],
            '2': ['2W', '2E', '2C', '2N', '2S'],
            '3': ['3W', '3E', '3C', '3N', '3S'],
            '4': ['4W', '4E', '4C', '4N', '4S']
        };
            
        // Populate dropdown with options based on selected form category
        classOptions[formCategory].forEach(function(option) {
            var opt = document.createElement('option');
            opt.value = option;
            opt.innerHTML = option;
            classroomDropdown.appendChild(opt);
        });
    }
</script> -->

</body>
</html>
