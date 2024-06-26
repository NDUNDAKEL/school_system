<?php
include('Database Operations/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize variables
$messageR = '';  // Variable to hold message for no subjects

// Get student data
$student_id = $_SESSION['schoolID'];
$sql_student = "SELECT * FROM student WHERE student_id = '$student_id'";
$result_student = mysqli_query($conn, $sql_student);

if ($result_student && mysqli_num_rows($result_student) > 0) {
    $row = mysqli_fetch_assoc($result_student);

    // Extract the classroom_id from the session and determine the form
    $classroom_id = $row['classroom_id'];
    $form_number = intval($classroom_id); // Extracts the leading numeric part

    // Handle AJAX request
    if (isset($_POST['addSubject'])) {
        $subjectID = $_POST['subject_id'];
        $sql_check = "SELECT * FROM subjects_taken WHERE Subect_id = '$subjectID' AND student_id = '$student_id'";
        $result_check = mysqli_query($conn, $sql_check);
        
        if (mysqli_num_rows($result_check) > 0) {
            echo "<script>alert('Subject already added to the student');</script>";
        } else {
            $sql = "SELECT * FROM subjects WHERE subject_id = '$subjectID'";
            $result = mysqli_query($conn, $sql);
            
            if ($result && $row1r = mysqli_fetch_assoc($result)) {
                $name = $row1r['name'];
                $teacher_id = $row1r['teacher_id'];
                $form_doing = $row1r['form_doing'];
                $term_doing = $row1r['term_done'];
                
                $sql_insert = "INSERT INTO subjects_taken (`Subect_id`, `student_id`, `subject_name`, `teacher_id`, `form`, `term`) 
                               VALUES ('$subjectID', '$student_id', '$name', '$teacher_id', '$form_doing', '$term_doing')";
                $result_insert = mysqli_query($conn, $sql_insert);
                
                if ($result_insert) {
                    echo "<script>alert('Subject added Successfully');</script>";
                } else {
                    echo "<script>alert('Error adding subject.');</script>";
                }
            } else {
                echo "<script>alert('Subject not found');</script>";
            }
        }
    }

    // Display subjects
    $queryr = "SELECT * FROM subjects WHERE form_doing = 'Form $form_number'";
    $resultr = mysqli_query($conn, $queryr);
    if ($resultr && mysqli_num_rows($resultr) > 0) {
        echo "
        <style>
        .register {
            margin-left: 250%;
            margin-right: 40px;
            width: 100%;
            height:auto;
            overflow:scroll;
        }
        
        table {
            border-collapse: collapse;
            width: 70%;
            margin: 10% auto;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        a {
            display: inline-block;
            width: auto;
            height: 20px;
            border-radius: 5px;
            color: white;
            padding: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        
        th {
            background-color: orange;
            color: white;
        }
        #add{
            background: blue;
            margin-right: 10%;
            border: none;
            border-radius: 5%;
            color: white;
            padding:10px;
            cursor:pointer;
        }
        .disabled {
            background-color: grey;
            pointer-events: none;
        }
        </style>";
        
        echo "<center>
                <h4 style='color:green;'>Click Register to add a subject</h4>
                <div class='register'>               
              </center>
              <table>
                <thead>
                    <tr>
                        <th>Subject Code</th>
                        <th>Name</th>
                        <th>Teacher ID</th>
                        <th>Form doing the Subject</th>
                        <th>Term subject is done</th>
                        <th>Registered State</th>
                        <th style='width:70px'>Action</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row1r = mysqli_fetch_assoc($resultr)) {
            $subjectID = $row1r['subject_id'];
            $sql_check = "SELECT * FROM subjects_taken WHERE Subect_id = '$subjectID' AND student_id = '$student_id'";
            $result_check = mysqli_query($conn, $sql_check);
            $registeredState = '';
            $disabled = false;
            
            if (mysqli_num_rows($result_check) > 0) {
                $registeredState = "<p style='color:green;'>Already Registered</p>";
                $disabled = true;
            } else {
                $registeredState = "<p style='color:red;'>Not Registered</p>";
                $disabled = false;
            }
            
            echo '<tr>';
            echo '<td>' . $row1r['subject_id'] . '</td>';
            echo '<td>' . $row1r['name'] . '</td>';
            echo '<td style="color:green;">' . $row1r['teacher_id'] . '</td>';
            echo '<td style="color:green;">' . $row1r['form_doing'] . '</td>';
            echo '<td style="color:green;">' . $row1r['term_done'] . '</td>';
            echo '<td style="color:green;">' . $registeredState . '</td>';
            echo '<td>';
            echo '<form method="post">';
            echo '<input type="hidden" name="subject_id" value="' . $row1r['subject_id'] . '">';
            echo '<button type="submit" name="addSubject" class="' . ($disabled ? 'disabled' : '') . '" style="background-color: ' . ($disabled ? 'grey' : 'blue') . '; width:80px; height:30px; color:white;"' . ($disabled ? ' disabled' : '') . '>Register</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        
        echo "</tbody>
              </table>
              </div>";
    } else {
        // No subjects found, display message
        $messageR = "<p style='color:red; text-align:center;'>No subjects found.</p>";
    }
} else {
    echo "<script>alert('Student not found');</script>";
}

// Display the message if set
if (!empty($messageR)) {
    echo $messageR;
}

mysqli_close($conn);
?>
