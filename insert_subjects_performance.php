<?php
include 'Database Operations/connect.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$getSubjects_taken = "SELECT * FROM subjects_taken";
$getresultsSubject = mysqli_query($conn, $getSubjects_taken);

while ($row = mysqli_fetch_assoc($getresultsSubject)) {
    $subject_id = $row['Subect_id'];
    $student_id = $row['student_id'];
    $subject_name = $row['subject_name'];
    $teacher_id = $row['teacher_id'];
    $form = $row['form'];
    $mark = $row['mark'];
    $term = $row['term'];
    $grade = $row['grade'];

    // Get the classroom_id of the student
    $getclass = "SELECT * FROM student WHERE student_id ='$student_id'";
    $resultclass = mysqli_query($conn, $getclass);

    if ($rowclass = mysqli_fetch_assoc($resultclass)) {
        $classId = $rowclass['classroom_id'];
    }

    // Get the mean mark for the subject in the class
    $meanQuery = "SELECT AVG(mark) AS mean_mark FROM subjects_taken 
                    INNER JOIN student ON subjects_taken.student_id = student.student_id 
                    WHERE subjects_taken.form = '$form' 
                    AND subjects_taken.term = '$term' 
                    AND subjects_taken.subject_name = '$subject_name' 
                    AND student.classroom_id = '$classId'";
    $resultMean = mysqli_query($conn, $meanQuery);
    $rowMean = mysqli_fetch_assoc($resultMean);
    $meanMark = $rowMean['mean_mark'];

    // Determine the grade based on the mean mark
    if ($meanMark >= 70) {
        $meanGrade = 'A';
    } elseif ($meanMark >= 60 && $meanMark < 70) {
        $meanGrade = 'B';
    } elseif ($meanMark >= 40 && $meanMark < 60) {
        $meanGrade = 'C';
    } else {
        $meanGrade = 'F';
    }

    // Get teacher name
    $getTeacherName = "SELECT name FROM teacher WHERE teacher_id = '$teacher_id'";
    $resultTeacherName = mysqli_query($conn, $getTeacherName);
    $rowTeacherName = mysqli_fetch_assoc($resultTeacherName);
    $teachername = $rowTeacherName['name'];

    // Count number of students
    $countQuery = "SELECT COUNT(*) AS student_count FROM subjects_taken 
                    INNER JOIN student ON subjects_taken.student_id = student.student_id 
                    WHERE subjects_taken.form = '$form' 
                    AND subjects_taken.term = '$term' 
                    AND subjects_taken.subject_name = '$subject_name' 
                    AND student.classroom_id = '$classId'";
    $resultCount = mysqli_query($conn, $countQuery);
    $rowCount = mysqli_fetch_assoc($resultCount);
    $studentCount = $rowCount['student_count'];

    // Insert into subject_mean table
    $insertQuery = "INSERT INTO subject_mean (subject_code, term_done, form_doing, classroom_id, teacher_teaching, number_of_students, marks, mean_grade) 
                    VALUES ('$subject_id', '$term', '$form', '$classId', '$teachername', '$studentCount', '$meanMark', '$meanGrade')";
    mysqli_query($conn, $insertQuery);
    
    echo "Mean mark for $subject_id in class $classId: $meanMark, Grade: $meanGrade, Teacher: $teachername, Number of Students: $studentCount <br>";
}
?>
