<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_code = filter_input(INPUT_POST, "subject_code", FILTER_SANITIZE_SPECIAL_CHARS);
    $subject_name = filter_input(INPUT_POST, "subject_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $teacher_id = filter_input(INPUT_POST, "teacher_id", FILTER_SANITIZE_NUMBER_INT);

    if (!empty($subject_name) && !empty($subject_code)) {
        $sql = "INSERT INTO subjects (`subject_id`, `name`, `teacher_id`) VALUES ('$subject_code', '$subject_name', '$teacher_id')";
        try {
            mysqli_query($conn, $sql);
            echo "<script>alert('Subject added successfully!');</script>";
            //header('location:editSubjects.php');
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('Error adding the subject. Make sure the subject code is unique');</script>";
        }
    }
}

$query = "SELECT * FROM teacher";
$result = mysqli_query($conn, $query);
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
            width: auto;
            height: auto;
            margin: 6%;
            padding: 10px; 
            background-color:orange;
            border-radius: 7px;
            box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
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
        
    </style>
</head>
<body>
    <a href="aboutUs.html">Back to School Page</a>
    <center>
        <div class="container">
            <div class="form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <img style="border-radius:9px;" src="../makuenilogo.png" alt="school logo"><br>
                    <label for="Student ID">Enter The student ID</label>
                    <input required type="number" name="student_id" placeholder="Enter the Student ID"><br>
                    <label for="subject_id ID">Enter The Subject ID</label>
                    <input required type="text" name="subject_id" placeholder="Enter the Subject ID"><br>
                    <label for="marks">Enter the marks scored</label>
                    <input required type="number" name="marks" placeholder="Enter the marks scored"><br>
                    <label for="teachers_comment">Write a comment on the student performance</label><br>
                    <textarea name="comment" cols="50" rows="7" placeholder="Subject Teacher Performance comment"></textarea>

</select><br>

                    <button type="submit" name="submit">Submit Marks</button>
                    <button onclick="window.location.href='editSubjects.php'" id="view" type="button" name="View">View marks</button>
 </form>
            </div>
    </center>
<footer>
    <center>
        <h2 style="color:green;"><span>Like a tree knowledge grows</span></h2>
        <p>Powered by School Space &copy 2024</p>
    </center>
</footer>
</div>
</body>
</html>