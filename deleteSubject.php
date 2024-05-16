<?php
include('Database Operations/connect.php');

if(isset($_POST['subject_id'])){
    $subjectID = $_POST['subject_id'];
    $sql = "DELETE FROM subjects_taken WHERE Subect_id = '$subjectID'";
    if (mysqli_query($conn, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
