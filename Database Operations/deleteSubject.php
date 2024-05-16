<?php
session_start();
include("connect.php");

if(isset($_SESSION['delete_subject'])){
    $id_to_delete = $_SESSION['delete_subject'];
    $queryS = "DELETE FROM subjects WHERE subject_id = '$id_to_delete'";
    $resultS = mysqli_query($conn, $queryS);
    if($resultS){
        echo "<script>alert('Subject Deleted successfully!');</script>";
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
        header('location: editSubjects.php');
    }
    else{
        echo "<script>alert('Error deleting Subject');</script>";
    }
}
?>
