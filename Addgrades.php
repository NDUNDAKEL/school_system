<?php
include 'Database Operations/connect.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$message = '';

// Split the session variable to get subject_id and student_id
list($subject_id, $student_id) = explode(',', $_SESSION['addgrade']);

// Fetch subject and student information based on the provided IDs
$query = "SELECT * FROM subjects_taken WHERE Subect_id = '$subject_id' AND student_id = '$student_id'";
$result = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $student_idS = $row['student_id'];
    $subject_idS = $row['Subect_id'];
    $subjectnameS = $row['subject_name'];
    $commentS = $row['comment'];
    $markS = $row['mark'];
    $form=$row['form'];
    $term=$row['term'];
}

$query1 = "SELECT * FROM student WHERE student_id = '$student_idS'";
$result1 = mysqli_query($conn, $query1);
if ($row1 = mysqli_fetch_assoc($result1)) {
    $student_nameS = $row1['name'];
    $classroom = $row1['classroom_id'];
}


$query2 = "SELECT * FROM classroom WHERE classroom_id = '$classroom'";
$result2 = mysqli_query($conn, $query2);
if ($row2 = mysqli_fetch_assoc($result2)) {
    $capacity = $row2['capacity'];
}

$query4 = "SELECT * FROM class_teachers WHERE class_id = '$classroom'";
$result4 = mysqli_query($conn, $query4);
if ($row4 = mysqli_fetch_assoc($result4)) {
    $classteacher_id = $row4['classteacher_id'];
}



$query5 = "SELECT * FROM teacher WHERE teacher_id = '$classteacher_id'";
$result5 = mysqli_query($conn, $query5);
if ($row5 = mysqli_fetch_assoc($result5)) {
    $teacher_name = $row5['name'];
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marks = filter_input(INPUT_POST, 'marks', FILTER_SANITIZE_SPECIAL_CHARS);
    $subject_code = filter_input(INPUT_POST, 'subject_code', FILTER_SANITIZE_SPECIAL_CHARS);
    $subject_name = filter_input(INPUT_POST, 'subject_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $student_id = filter_input(INPUT_POST, 'student_id', FILTER_SANITIZE_SPECIAL_CHARS);
    $student_name = filter_input(INPUT_POST, 'student_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_SPECIAL_CHARS);

    // Determine grade based on marks
    if ($marks < 40) {
        $grade = 'F';
    } elseif ($marks >= 40 && $marks <= 49) {
        $grade = 'D';
    } elseif ($marks >= 50 && $marks <= 59) {
        $grade = 'C';
    } elseif ($marks >= 60 && $marks <= 69) {
        $grade = 'B';
    } elseif ($marks >= 70 && $marks <= 100) {
        $grade = 'A';
    } else {
        echo "<script>alert('There is no such grade $grade');</script>";
    }

    // Update the database with the new marks, grade, and comment
    $sql = "UPDATE subjects_taken SET `mark` = '$marks', `grade` = '$grade', `comment` = '$comment' WHERE `Subect_id` = '$subject_id' AND `student_id` = '$student_idS'";
    try {
        $query9 = mysqli_query($conn, $sql);
        if ($query9) {
            echo "<script>alert('Marks updated successfully');</script>";
            $message = "<p style='color:green;'>Student grade is {$grade}</p>";

            // Calculate the new class mean and update the classroom_mean table
            $query3 = "SELECT * FROM student WHERE classroom_id = '$classroom'";
            $result3 = mysqli_query($conn, $query3);
            $totalMarks = 0;
            $totalStudents = 0;


            while ($row3 = mysqli_fetch_assoc($result3)) {
                $studentId = $row3['student_id'];
                $queryMarks = "SELECT * FROM subjects_taken WHERE student_id = '$studentId'";
                $resultMarks = mysqli_query($conn, $queryMarks);
                $studentTotalMarks = 0;
                $subjectsCount = 0;
                while ($rowMarks = mysqli_fetch_assoc($resultMarks)) {
                    $studentTotalMarks += $rowMarks['mark'];
                    $subjectsCount++;
                }
                if ($subjectsCount > 0) {
                    $studentMeanMarks = $studentTotalMarks / $subjectsCount;
                    $totalMarks += $studentMeanMarks;
                    $totalStudents++;
                }
            }

            $classMean = 0;
            $classMeanGrade = 'N/A';
            if ($totalStudents > 0) {
                $classMean = $totalMarks / $totalStudents;

                // Determine class mean grade based on mean marks
                if ($classMean < 40) {
                    $classMeanGrade = 'F';
                } elseif ($classMean >= 40 && $classMean <= 49) {
                    $classMeanGrade = 'D';
                } elseif ($classMean >= 50 && $classMean <= 59) {
                    $classMeanGrade = 'C';
                } elseif ($classMean >= 60 && $classMean <= 69) {
                    $classMeanGrade = 'B';
                } elseif ($classMean >= 70 && $classMean <= 100) {
                    $classMeanGrade = 'A';
                }
            }

            // Check if classroom_id exists in classroom_mean table
            $check_query = "SELECT * FROM classroom_mean WHERE classroom_id = '$classroom'";
            $check_result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                // Update the existing record
                $update_query = "UPDATE classroom_mean SET class_capacity = '$capacity', class_teacher = '$teacher_name', form='$form', term='$term', mean_grade = '$classMeanGrade', mean_marks = '$classMean' WHERE classroom_id = '$classroom'";
                mysqli_query($conn, $update_query);
            } else {
                // Insert a new record
                $insert_query = "INSERT INTO classroom_mean (classroom_id, class_capacity, class_teacher, form, term, mean_grade, mean_marks, teacher_comments)
                                VALUES ('$classroom', '$capacity', '$teacher_name', '$form', '$term', '$classMeanGrade', '$classMean', NULL)";
                mysqli_query($conn, $insert_query);
            }
        } else {
            echo "<script>alert('Error updating marks');</script>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
    <style>
        body {
            background-color: aliceblue;
        }
        .form {
            display: inline-block;
            color: white;
            margin: 6%;
            padding: 10px; 
            background-color: orange;
            border-radius: 7px;
        }
        footer {
            color: rgb(255, 0, 191);
            margin: 0%;
            height: auto;
        }
        button {
            background: blue;
            font-weight: bolder;
            color: white;
            border-radius: 5px;
            width: 60%;
            height: 30px;
            border: none;
            cursor: pointer;
            margin: 20px;
        }
        #view {
            background-color: blue;
        }
        label {
            color: white;
        }
        input {
            width: 100%;
            height: 30px;
            border: none;
            color: black;
            background-color: aquamarine;
            border-radius: 5px;
        }
        p {
            cursor: pointer;
        }
        .container {
            background-color: aliceblue;
        }
        a {
            background-color: blue;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <a style='background:none; text-decoration:underline; color:black;' href="teacher_subjects_grading.php">Back</a>
    <center>
        <div class="container">
            <div class="form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <img src="./makuenilogo.png" alt="school logo"><br>
                    <label for="subject_code">Subject Code</label>
                    <input disabled required type="text" name="subject_code" value="<?php echo $subject_idS ?>" placeholder="Subject code"><br>
                    <label for="student_id">Student ID</label>
                    <input disabled required type="text" name="student_id" value="<?php echo $student_idS ?>" placeholder="Student ID"><br>
                    <label for="subject_name">Subject name</label>
                    <input disabled required type="text" name="subject_name" value="<?php echo $subjectnameS ?>" placeholder="Subject name"><br>
                    <label for="student_name">Student name</label>
                    <input disabled required type="text" name="student_name" value="<?php echo $student_nameS ?>" placeholder="Student name"><br>
                    <label for="marks">Marks</label>
                    <input required type="number" max="100" min="0" name="marks" value="<?php echo $markS; ?>" placeholder="Enter the marks scored"><br>
                    <label for="comment">Comment on the student Performance</label><br>
                    <textarea rows="5" cols="50" name="comment" placeholder="Comment on the student Performance"><?php echo isset($commentS) ? $commentS : ''; ?></textarea><br>
                    <center>
                        <button type="submit" name="submit">Submit</button>
                    </center>
                </form>
            </div>
            <?php echo "$message "; ?>
         
        </div>
    </center>
    <footer>
        <center>
            <h2 style="color: green;"><span>Like a tree knowledge grows</span></h2>
            <p>Powered by School Space &copy; 2024</p>
        </center>
    </footer>
</body>
</html>
