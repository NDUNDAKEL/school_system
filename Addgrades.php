<?php
include 'Database Operations/connect.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$message='';
$subject_id=$_SESSION['addgrade'];
$query= "SELECT * FROM subjects_taken WHERE Subect_id = '$subject_id'";
$result=mysqli_query($conn,$query);
if($row=mysqli_fetch_assoc($result)){
    $student_idS=$row['student_id'];
    $subject_idS=$row['Subect_id'];
    $subjectnameS=$row['subject_name'];
    $commentS=$row['comment'];
    $markS=$row['mark'];
   
}
$query1= "SELECT * FROM student WHERE student_id = '$student_idS'";
$result1=mysqli_query($conn,$query1);
if($row1=mysqli_fetch_assoc($result1)){
  $student_nameS=$row1['name'];
  $classroom=$row1['classroom_id'];
}
  $query2="SELECT * FROM classroom WHERE classroom_id ='$classroom'";
  $result2=mysqli_query($conn,$query2);
  if($row2=mysqli_fetch_assoc($result2)){
    $capacity=$row2['capacity'];
  }
  $query3="SELECT * FROM subjects_taken WHERE student_id ='$student_idS'";
  $result3=mysqli_query($conn,$query3);
  while($row3=mysqli_fetch_assoc($result3)){
    $totalMarks=0;
    $marksStudent=$row3['mark'];
    $totalMarks=$totalMarks+$marksStudent;
    echo $totalMarks;
  }

include('Database Operations/connect.php');
$grade='';
$marks=filter_input(INPUT_POST,'marks',FILTER_SANITIZE_SPECIAL_CHARS);
$subject_code=filter_input(INPUT_POST,'subject_code',FILTER_SANITIZE_SPECIAL_CHARS);
$subject_name=filter_input(INPUT_POST,'subject_name',FILTER_SANITIZE_SPECIAL_CHARS);
$student_id=filter_input(INPUT_POST,'student_id',FILTER_SANITIZE_SPECIAL_CHARS);
$student_name=filter_input(INPUT_POST,'student_name',FILTER_SANITIZE_SPECIAL_CHARS);
$comment=filter_input(INPUT_POST,'comment',FILTER_SANITIZE_SPECIAL_CHARS);


if($marks < 40){
    $grade = 'F';
}elseif($marks >40 && $marks <=49){
    $grade = 'D';
}
elseif($marks >50 && $marks <=59){
    $grade = 'C';
}
elseif($marks >60 && $marks <=69){
    $grade = 'B';
}
elseif($marks >70 && $marks <=100){
    $grade = 'A';
}
else{
    echo "<script> alert('There is no such grade $grade')</script>";
}

if(isset($_SESSION['addgrade'])){
    // echo "hello";
}
$sql = "UPDATE subjects_taken SET `mark` = '$marks', `grade` = '$grade', `comment` = '$comment' WHERE `Subect_id` = '$subject_id' AND `student_id` = '$student_id'";

try {
    $query9 = mysqli_query($conn, $sql);
    if ($query9) {
        echo "<script>alert('Marks updated successfully');</script>";
        $message="<p style='color:green;'>Student grade is {$grade}</p>";
    } else {
        echo "<script>alert('Error updating marks');</script>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
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
            width:60%;
         
            height: 30px;
            border: none;
            cursor: pointer;
            margin:20px;
        }
        #view{
            background-color:blue;
        }
        label{
            color: white;
            /* font:sans-sarif; */
        }
        input{
            width: 100%;
            height: 30px;
            border: none;
            color:black;
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
    <a href="teacher_subjects_grading.php">Back to School Page</a>
    <center>
        <div class="container">
            <div class="form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <img src="./makuenilogo.png" alt="school logo"><br>
                    <label for="Subject ID">Subject Code</label>
                    <input required type="text" name="subject_code" value="<?php echo $subject_idS ?>" placeholder="Subject code"><br>
                    <label for="Subject ID">Student ID</label>
                    <input required type="text" name="student_id" value="<?php echo $student_idS ?>" placeholder="Student ID"><br>
                    <label for="subject_namae">Subject name</label>
                    <input required type="text" name="subject_name" value="<?php echo $subjectnameS ?>" placeholder="Subject name"><br>
                    <label for="subject_namae">Student name</label>
                    <input required type="text" name="subject_name" value="<?php echo $student_nameS ?>" placeholder="Subject name"><br>
                    <label for="marks">Marks</label>
                    <input required type="number" max="100" min="0" name="marks" value="<?php echo $markS; ?>" placeholder="Enter the marks scored"><br>
                    <label for="comment" value=''>Comment on the student Performance</label><br>
                    <textarea rows='5' cols='50' name='comment' placeholder='Comment on the student Performance'><?php echo isset($commentS) ? $commentS : ''; ?></textarea><br>

<center>
<button type="submit" name="submit">Submit</button>               <!-- <button onclick="window.location.href='editSubjects.php'" id="view" type="button" name="View">View subjects</button> -->
 </form>
            </div>
            <?php echo "$message "?>
        </div>
    </center>
    <footer>
        <center>
            <h2 style="color:green;"><span>Like a tree knowledge grows</span></h2>
            <p>Powered by School Space &copy 2024</p>
        </center>
    </footer>
</body>
</html>









