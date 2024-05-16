<?php
include('Database Operations/connect.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session
if (isset($_SESSION["schoolID"])) {
    $id = $_SESSION["schoolID"];
}

if(isset($_POST['deleteSubject'])){
    $subjectID = $_POST['subject_id'];
    $sql = "DELETE FROM subjects_taken WHERE Subect_id = '$subjectID'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Subject deleted Successfully');</script>";
    } else {
        echo "<script>alert('Failed to delete subject');</script>";
    }
}

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
</style>
<center>
<h4 style='color:green;'>Your Subjects.</h4> <!-- Closing h4 tag added -->
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
        <th style='width:70px'>Action</th>
    </tr>
</thead>

<tbody id='subjectList'>
";

$messageR = "";
$queryr = "SELECT * FROM subjects_taken WHERE student_id = '$id'";
$resultr = mysqli_query($conn, $queryr);

if (mysqli_num_rows($resultr) > 0) {
    while ($row1r = mysqli_fetch_assoc($resultr)) {
        echo '<tr>';
        echo '<td>' . $row1r['Subect_id'] . '</td>';
        echo '<td>' . $row1r['subject_name'] . '</td>';
        echo '<td style="color:green;">' . $row1r['teacher_id'] . '</td>';
        echo '<td style="color:green;">' . $row1r['form'] . '</td>';
        echo '<td style="color:green;">' . $row1r['term'] . '</td>';
        echo '<td>';
        echo '<form method="post">';
        echo '<input type="hidden" name="subject_id" value="' . $row1r['Subect_id'] . '">';
        echo '<button type="submit" name="deleteSubject" style="background-color:red; cursor:pointer;  width:80px; height:30px; color:white;">Delete</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    
    }
} else {
    $messageR = "<tr style='color:red;'><td colspan='6'>No subjects found.</td></tr>";
}

echo "
</tbody>
</table>
</div>
";
?>

