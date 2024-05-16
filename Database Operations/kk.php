
<?php
 include("connect.php");

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
    <h1 style='color:red'>Student Management</h1>
    <form method='POST' action='<?php $_SERVER['PHP_SELF']; ?>'>
    <div id="search-bar">
        <label for="search-input">Search by:</label>
        <input name='term' type="text" id="search-input" placeholder="Enter search term">
        <select name='filter' id="filter-select">
            <option name='filter' value="All">All students</option>
            <option name='filter' value="student_id">Student ID</option>
            <option name='filter' value="email">Student Email</option>
            <option name='filter'value="name">Name</option>
            <option name='filter' value="classroom_id">Classroom</option>
            <option name='filter' value="dormitory">Dormitory</option>
            <option name='filter' value="indexnumber">KCPE index number</option>
            <!-- Add more options here if needed -->
        </select>
        <button name="search">Search</button>
    </div>
    </form>
    <div id="student-table">
        <!-- Table content will be dynamically generated using JavaScript -->
    </div>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Form</th>
                <th>Name</th>
                <th>KCPE INDEX NUMBER</th>
                <th>Email</th>
                <th>Classroom</th>
                <th>Dormitory</th>
                <th>Date of Birth</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- PHP code for populating table rows -->
        <?php
if(!isset($search) || ($search == '' && $filter == 'All')) {
    $sql = "SELECT * FROM student";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td style='color:orange;'>" . $row['student_id'] . "</td>";
            echo "<td style='color:orange;'>" . $row['form'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['indexnumber'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td style='color:green;'>" . $row['classroom_id'] . "</td>";
            echo "<td>" . $row['dormitory'] . "</td>";
            echo "<td>" . $row['DOB'] . "</td>";
            echo "<td>";
            echo "";
            echo "<button name='delete_{$row['student_id']}'></button>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr style='color:red;'><td colspan='8'>No students found.</td></tr>";
    }
} elseif($filter == 'student_id') {
    $query = "SELECT * FROM student WHERE student_id = '$term'";
    $result1 = mysqli_query($conn, $query);
    if($result1 && mysqli_num_rows($result1) > 0) {
        while($student_id_results = mysqli_fetch_assoc($result1)) {
            echo "<tr>";
            echo "<td style='color:orange;'>" . $student_id_results['student_id'] . "</td>";
            echo "<td style='color:orange;'>" . $student_id_results['form'] . "</td>";
            echo "<td>" . $student_id_results['name'] . "</td>";
             echo "<td>" . $student_id_results['indexnumber'] . "</td>";
            echo "<td>" . $student_id_results['email'] . "</td>";
            echo "<td style='color:green;'>" . $student_id_results['classroom_id'] . "</td>";
            echo "<td>" . $student_id_results['dormitory'] . "</td>";
            echo "<td>" . $student_id_results['DOB'] . "</td>";
            echo "<td>";
            echo "<a style='background-color:yellow; color:black;' href='editStudent.php?id=" . $student_id_results['student_id'] . "'>Edit</a> | ";
            echo "<a style='background-color:red; color:white;' href='deleteStudent.php?id=" . $student_id_results['student_id'] . "' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8' style='color:red;'>No students found with id: $term.</td></tr>";
    }
}
    elseif($filter == 'classroom_id') {
    $query2 = "SELECT * FROM student WHERE classroom_id = '$term'";
    $result2 = mysqli_query($conn, $query2);
    if($result2 && mysqli_num_rows($result2) > 0) {
        while($classroom_results = mysqli_fetch_assoc($result2)) {
            echo "<tr>";
            echo "<td style='color:orange;'>" . $classroom_results['student_id'] . "</td>";
            echo "<td style='color:orange;'>" . $classroom_results['form'] . "</td>";
            echo "<td>" . $classroom_results['name'] . "</td>";
            echo "<td>" . $classroom_results['indexnumber'] . "</td>";
            echo "<td>" . $classroom_results['email'] . "</td>";
            echo "<td style='color:green;'>" . $classroom_results['classroom_id'] . "</td>";
            echo "<td>" . $classroom_results['dormitory'] . "</td>";
            echo "<td>" . $classroom_results['DOB'] . "</td>";
            echo "<td>";
            echo "<a style='background-color:yellow; color:black;' href='editStudent.php?id=" . $classroom_results['student_id'] . "'>Edit</a> | ";
            echo "<a style='background-color:red; color:white;' href='deleteStudent.php?id=" . $classroom_results['student_id'] . "' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8' style='color:red;'>No students found in classroom : $term.</td></tr>";
    
    }
}
     elseif($filter == 'indexnumber') {
    $query3 = "SELECT * FROM student WHERE indexnumber= '$term'";
    $result3 = mysqli_query($conn, $query3);
    if($result3 && mysqli_num_rows($result3) > 0) {
        while($indexnumber_results = mysqli_fetch_assoc($result3)) {
            echo "<tr>";
            echo "<td style='color:orange;'>" . $indexnumber_results['student_id'] . "</td>";
            echo "<td style='color:orange;'>" . $indexnumber_results['form'] . "</td>";
            echo "<td>" . $indexnumber_results['name'] . "</td>";
             echo "<td>" . $indexnumber_results['indexnumber'] . "</td>";
            echo "<td>" . $indexnumber_results['email'] . "</td>";
            echo "<td style='color:green;'>" . $indexnumber_results['classroom_id'] . "</td>";
            echo "<td>" . $indexnumber_results['dormitory'] . "</td>";
            echo "<td>" . $indexnumber_results['DOB'] . "</td>";
            echo "<td>";
            echo "<a style='background-color:yellow; color:black;' href='editStudent.php?id=" . $indexnumber_results['student_id'] . "'>Edit</a> | ";
            echo "<a style='background-color:red; color:white;' href='deleteStudent.php?id=" . $indexnumber_results['student_id'] . "' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6' style='color:red;>No student found with index number  : $term.</td></tr>";
    
    }
  }  elseif($filter == 'email') {
    $query4 = "SELECT * FROM student WHERE email= '$term'";
    $result4 = mysqli_query($conn, $query4);
    if($result4 && mysqli_num_rows($result4) > 0) {
        while($email_results = mysqli_fetch_assoc($result4)) {
            echo "<tr>";
            echo "<td style='color:orange;'>" . $email_results['student_id'] . "</td>";
            echo "<td style='color:orange;'>" . $email_results['form'] . "</td>";
            echo "<td>" . $email_results['name'] . "</td>";
             echo "<td>" . $email_results['indexnumber'] . "</td>";
            echo "<td>" . $email_results['email'] . "</td>";
            echo "<td style='color:green;'>" . $email_results['classroom_id'] . "</td>";
            echo "<td>" . $email_results['dormitory'] . "</td>";
            echo "<td>" . $email_results['DOB'] . "</td>";
            echo "<td>";
            echo "<a style='background-color:yellow; color:black;' href='editStudent.php?id=" . $email_results['student_id'] . "'>Edit</a> | ";
            echo "<a style='background-color:red; color:white;' href='deleteStudent.php?id=" . $email_results['student_id'] . "' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6' style='color:red;>No student found with index number  : $term.</td></tr>";
    
    }
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



