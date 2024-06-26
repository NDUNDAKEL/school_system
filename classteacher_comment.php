<?php
include ('Database Operations/connect.php');
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
session_start();
// Prevent the page from being cached by the browser
if(isset($_SESSION['classteacher_id'])){
    $classteacherid=$_SESSION['classteacher_id'];
}
$getclass="SELECT   * FROM class_teachers WHERE classteacher_id ='$classteacherid'";
$getresults=mysqli_query($conn,$getclass);
if($getrow=mysqli_fetch_assoc($getresults)){
    $class=$getrow['class_id'];
}
$getteachername="SELECT   * FROM teacher WHERE teacher_id ='$classteacherid'";
$getresul=mysqli_query($conn,$getteachername);
if($getrow1=mysqli_fetch_assoc($getresul)){
    $teacher_name=$getrow1['name'];
}
function logout() {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Set headers to prevent caching
    header("Cache-Control: no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Redirect to the login page
    header("Location: classteacherlogin.php");
    exit();
}


// Logout if logout form submitted
if (isset($_POST['logout'])) {
    logout();
}
// header("Cache-Control: no-store, must-revalidate");
// header("Pragma: no-cache");
// header("Expires: 0");
// Search and filter subjects taken
// Fetch subjects taught by the teacher

$querystudentmean= "SELECT * FROM student_mean WHERE classroom_id = '$class'";
                        $resultstudentmean = mysqli_query($conn, $querystudentmean);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: black;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links {
            display: flex;
            gap: 10px;
        }

        .nav-link {
            color: yellow;
            cursor: pointer;
            text-decoration: underline;
        }

        .logout-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-input {
            height: 30px;
            border-radius: 5px;
            padding: 5px;
            margin-right: 10px;
        }

        .filter-select {
            height: 30px;
            border-radius: 5px;
            margin-right: 10px;
        }

        .search-btn {
            background-color: black;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .register {
            margin: 0 auto;
            width: 70%;
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        th {
            background-color: orange;
            color: white;
        }

        .add-grade-btn {
            background-color: blue;
            color: white;
            text-decoration: none;
            cursor:pointer;
            width: 70px;
            height: 40px;
            width: auto;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h4>Teacher: <?php echo $teacher_name; ?> <?php ?></h4>
            <div class="nav-links">
                <button onClick='showClass()' id='class'>Comment class performance</button>
                <button onClick='showstudent()'id='student'>Student Performance</button>
                <button onClick='showPer()'id='performance'>Subject Performance</button>
            </div>
            <?php echo $class; ?>
            <form method="post" action="classteacher_comment.php">
                <button class="logout-btn" name="logout">Log out</button>
            </form>
        </div>
        <div id="commentstudent">
            <div class="search-container">
                <form method="POST" action="classteacher_comment.php">
                    <p style="color: blue;">Based on:</p>
    
                    <input class="search-input" type="text" name="term" placeholder="Search student ID">
                    <button class="search-btn" name="search">Search</button>
                </form>
            </div>
            <div class="register">
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Classroom ID/th>
                            <th> Form</th>
                            <th>Term</th>
                            <th>mean marks</th>
                            <th>mean grade</th>
                            <th>Class teacher Comment</th>
                            <th style="width: 70px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!isset($_POST['search' && empty($term)])){
                        while ($row9 = mysqli_fetch_assoc($resultstudentmean)) {
                            echo '<tr>';
                            echo '<td style="color:green;">' . $row9['student_id'] . '</td>';
                            echo '<td style="color:green;">'.$row9['student_name']. '</td>';
                            echo '<td style="color:green;">' . $row9['classroom_id'] . '</td>';
                            echo '<td style="color:grey;">' . $row9['form'] . '</td>';
                            echo '<td style="color:blue;">' . $row9['term'] . '</td>';
                            echo '<td style="color:red;">' . $row9['student_mean'] . '</td>';
                            echo '<td style="color:green;">' . $row9['mean_grade'] . '</td>';
                            echo '<td>';
                            echo "<form method='POST' action='classteacher_comment.php'>
                                <textarea rows='5' cols='50' name='commentstudent' placeholder='Write a comment on class performance'>" . $row9['teacher_comment'] . "</textarea>
                            </td>
                            <td>
                                <button style='background-color:green; color:white' type='submit' name='studentcomment'>Comment</button>
                            </form>";
                            echo '</td>';
                            echo '</tr>';
                        
                            if(isset($_POST['studentcomment'])){
                                $commentstudent = $_POST['commentstudent'];
                                if(!empty($commentstudent)){
                                    $updatestudent = "UPDATE student_mean SET teacher_comment='$commentstudent' WHERE student_id ='{$row9['student_id']}' AND form ='{$row9['form']}' AND term ='{$row9['term']}'";
                                    $resultstudent = mysqli_query($conn, $updatestudent);
                                    if($resultstudent){
                                        echo "<script>alert('Success')</script>";
                                    } else {
                                        echo "<script>alert('Error')</script>";
                                    }
                                } else {
                                    echo "<script>alert('Please enter a comment')</script>";
                                }
                            }
                        }
                    }else{
                        $querystudentmeanS= "SELECT * FROM student_mean WHERE classroom_id = '$class'";
                        $resultstudentmeanS = mysqli_query($conn, $querystudentmeanS);
                        if ($row8 = mysqli_fetch_assoc($resultstudentmeanS)) {
                            echo '<tr>';
                            echo '<td style="color:green;">' . $row9['student_id'] . '</td>';
                            echo '<td style="color:green;">'.$row9['student_name']. '</td>';
                            echo '<td style="color:green;">' . $row9['classroom_id'] . '</td>';
                            echo '<td style="color:grey;">' . $row9['form'] . '</td>';
                            echo '<td style="color:blue;">' . $row9['term'] . '</td>';
                            echo '<td style="color:red;">' . $row9['student_mean'] . '</td>';
                            echo '<td style="color:green;">' . $row9['mean_grade'] . '</td>';
                            echo '<td>';
                            echo "<form method='POST' action='classteacher_comment.php'>
                                <textarea rows='5' cols='50' name='commentstudent1' placeholder='Write a comment on class performance'>" . $row9['teacher_comment'] . "</textarea>
                            </td>
                            <td>
                                <button style='background-color:green; color:white' type='submit' name='studentcomment'>Comment</button>
                            </form>";
                            echo '</td>';
                            echo '</tr>';
                        
                            if(isset($_POST['studentcomment'])){
                                $commentstudent1 = $_POST['commentstudent1'];
                                if(!empty($commentstudent1)){
                                    $updatestudent1 = "UPDATE student_mean SET teacher_comment='$commentstudent1' WHERE student_id ='{$row8['student_id']}' AND form ='{$row8['form']}' AND term ='{$row8['term']}'";
                                    $resultstudent1 = mysqli_query($conn, $updatestudent1);
                                    if($resultstudent1){
                                        echo "<script>alert('Success')</script>";
                                    } else {
                                        echo "<script>alert('Error')</script>";
                                    }
                                } else {
                                    echo "<script>alert('Please enter a comment')</script>";
                                }
                            }
                        }else{
                            echo "<script>alert('No student found with ID : {$row9['student_id']}')</script>";
                        }
                    }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id='showclass'>
<?php
$getclassmean = "SELECT * FROM classroom_mean WHERE classroom_id ='$class'";
$resultclassmean = mysqli_query($conn, $getclassmean);
echo "
<table>
<thead>
    <tr>
        <th>Classroom ID</th>
        <th>Class Capacity</th>
        <th>Class Teacher</th>
        <th>Form</th>
        <th>Term</th>
        <th>Mean Marks</th>
        <th>Mean Grade</th>
        <th>Class Teacher Comment</th>
        <th style='width: 70px'>Action</th>
    </tr>
</thead>
<tbody>";
while ($rowclassmean = mysqli_fetch_assoc($resultclassmean)) {
    $teacherComment = $rowclassmean['teacher_comments'] !== null ? $rowclassmean['teacher_comments'] : 'Null';
    echo "
    <tr>
        <td>{$rowclassmean['classroom_id']}</td>
        <td>{$rowclassmean['class_capacity']}</td>
        <td>{$rowclassmean['class_teacher']}</td>
        <td>{$rowclassmean['form']}</td>
        <td>{$rowclassmean['term']}</td>
        <td>{$rowclassmean['mean_marks']}</td>
        <td>{$rowclassmean['mean_grade']}</td>
        <td>
            <form method='POST' action='classteacher_comment.php'>
            <textarea rows='5' cols='50' name='commentperformance' placeholder='Write a comment on class performance'>" . $rowclassmean['teacher_comments'] . "</textarea>
            <input type='hidden' name='classroom_id' value='{$rowclassmean['classroom_id']}'>
        </td>
        <td>
                <button style='background-color:green; color:white' type='submit' name='comment'>Comment</button>
            </form>
        </td>
    </tr>";
    // Process form submission
    if(isset($_POST['comment'])){
        $comment = $_POST['commentperformance'];
        $classroom_id = $_POST['classroom_id'];
        
        if(!empty($comment)){
            $updateclass = "UPDATE classroom_mean SET teacher_comments='$comment' WHERE classroom_id ='$classroom_id'";
            $resultclass = mysqli_query($conn, $updateclass);
            if($resultclass){
                echo "<script>alert('Success')</script>";
            } else {
                echo "<script>alert('Error')</script>";
            }
        } else {
            echo "<script>alert('Please enter a comment')</script>";
        }
    }
}
echo "
</tbody>
</table>";
?>
</div>
</div>
    </div>
    <div id='showSubjectsperformance'>
    <?php
$getsubject = "SELECT * FROM subject_mean WHERE classroom_id ='$class'";
$resultsubject = mysqli_query($conn, $getsubject);

echo "
<table>
<thead>
    <tr>
        <th>Subject ID</th>
        <th>Term Done</th>
        <th>Form Doing</th>
        <th>Classroom ID</th>
        <th>Teacher Teaching</th>
        <th>Number of Students</th>
        <th>Marks</th>
        <th>Mean</th>
        <th>Teacher's Comment</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>";

while ($row = mysqli_fetch_assoc($resultsubject)) {
    echo "
    <tr>
        <td style='color:green'>{$row['subject_code']}</td>
        <td style='color:orange'>{$row['term_done']}</td>
        <td style='color:green'>{$row['form_doing']}</td>
        <td style='color:blue'>{$row['classroom_id']}</td>
        <td style='color:black'>{$row['teacher_teaching']}</td>
        <td  style='color:green'>{$row['number_of_students']}</td>
        <td style='color:grey'>{$row['marks']}</td>
        <td style='color:red'>{$row['mean_grade']}</td>
        <td>
            <form method='POST' action=''>
                <textarea rows='3' cols='30' name='teacher_comment'>{$row['classteacher_comment']}</textarea>
                <input type='hidden' name='subject_id' value='{$row['subject_code']}'>
                <input type='hidden' name='classroom_id' value='{$row['classroom_id']}'>
        </td>
        <td>
                <button type='submit' name='submit_comment'>Submit</button>
            </form>
        </td>
    </tr>";
}

echo "
</tbody>
</table>";

// Process form submission
if(isset($_POST['submit_comment'])){
    $teacher_comment = $_POST['teacher_comment'];
    $subject_id = $_POST['subject_id'];
    $classroom_id = $_POST['classroom_id'];
    
    if(!empty($teacher_comment)){
        // Update teacher's comment in the database
        $updateQuery = "UPDATE subject_mean SET classteacher_comment='$teacher_comment' WHERE subject_code='$subject_id' AND classroom_id='$classroom_id'";
        $resultUpdate = mysqli_query($conn, $updateQuery);
        
        if($resultUpdate){
            echo "<script>alert('Comment submitted successfully.')</script>";
        } else {
            echo "<script>alert('Error occurred while submitting comment.')</script>";
        }
    } else {
        echo "<script>alert('Please enter a comment.')</script>";
    }
}
?>

</div>

<script>
const student=document.getElementById('commentstudent');
const Class=document.getElementById('showclass');
const studentbtn=document.getElementById('student');
const Classbtn=document.getElementById('class');
const performancediv=document.getElementById('showSubjectsperformance');
const performance=document.getElementById('performance');
performancediv.style.display='none';
Class.style.display='none';
studentbtn.style.background='green'
studentbtn.style.color='white'
function showstudent(){
    student.style.display='block'
    Class.style.display='none';
    studentbtn.style.background='green'
    studentbtn.style.color='white'
    Classbtn.style='none';
    performancediv.style.display='none';
    performance.style.background='white';
    performance.style.color='black';

}
function showClass(){
    student.style.display='none'
    Class.style.display='block';
    Classbtn.style.background='green'
    Classbtn.style.color='white'
    studentbtn.style='none'
    performancediv.style.display='none';
    performance.style.background='white';
    performance.style.color='black';
}
function showPer(){
    student.style.display='none'
    Class.style.display='none';
    Classbtn.style.background='none'
    Classbtn.style.color='white'
    studentbtn.style='none'
    performancediv.style.display='block';
    performance.style.background='green';
    performance.style.color='white';
}
</script>
</body>
</html>
