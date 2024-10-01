
<?php
 include("connect.php");
 if(isset($_GET['delete'])) {
session_start();
$_SESSION['id_to_delete'] = $_GET['delete'];
 
   header('Location:deleted_students.php');
    // $query = "DELETE FROM student WHERE student_id = '$id'";
    // mysqli_query($conn, $query);
    // // Redirect back to the page after deleting
    // header("Location: ".$_SERVER['PHP_SELF']);
    // exit(); // Stop further execution
}

     $filter=$_POST['filter'];
     $search=$_POST['search'];
     $term=filter_input(INPUT_POST,'term',FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($search) && !empty($term) && !empty($search)){
    if($filter=='student_id'){
       $query="SELECT * FROM student WHERE student_id = '$term'";
       $result1=mysqli_query($conn,$query);
while($student_id_results=mysqli_fetch_assoc($result1)){
    // echo $student_id_results['email'];
}
     }
    }
     // Fetch student data from the database
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <style>
        /* Consolidated styles */
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

        /* Footer styling */
        footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<a href="deleted_students.php"> <span style="color:Black height:auto; width:auto; background-color:green;">>Go Back <</span><i class="fas fa-sign-in-alt"></i></a> 
    <center>
<h1 style="color:blue">Makueni Boys High School</h1>

    </center>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Reason for deleting student</th>
                <th>Deleted at</th>
        </thead>
        <tbody>
            <!-- PHP code for populating table rows -->
        <?php
    $sql = "SELECT * FROM deleted_students";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td style='color:orange;'>" . $row['student_id'] . "</td>";
            echo "<td style='color:orange;'>" . $row['name'] . "</td>";
            echo "<td>" . $row['reason_for_deletion'] . "</td>";
            echo "<td>" . $row['deleted_at'] . "</td>";
         echo "</tr>";
        }
    } else {
        echo "<tr style='color:red;'><td colspan='8'>No students found.</td></tr>";
    }
mysqli_close($conn);
?>


        </tbody>
    </table>
    <button id="add" onclick="window.location.href='student.php'">Add New Student</button>

    <footer>
        <p style="color: blue;">Makueni Boys Admin Panel Edit Subjects</p>
        <p style="color: orange;">&copy KEliFE 2024</p>
    </footer>
    
</body>
</html>









