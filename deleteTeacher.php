<?php
session_start();
include("connect.php");

if(isset($_SESSION['teacher_id_to_delete'])){
    $id_to_delete = $_SESSION['teacher_id_to_delete'];
    $queryS = "DELETE FROM teacher WHERE teacher_id = '$id_to_delete'";

    $resultS = mysqli_query($conn, $queryS);
    if($resultS){
        echo "<script>alert('Teacher Deleted successfully!');</script>";
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
        header('location: showTeachers.php');
    }
    else{
        echo "<script>alert('Error deleting Teacher');</script>";
    }
}
?>
