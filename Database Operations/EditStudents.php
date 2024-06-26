<?php
include("connect.php");

$filter = $_POST['filter'] ?? 'All';
$search = $_POST['search'] ?? '';
$term = filter_input(INPUT_POST, 'term', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($_GET['editStudent'])) {
    session_start();
    $_SESSION['id_to_edit'] = $_GET['editStudent'];
    header('Location:EditstudentInfo.php');
    exit();
} elseif (isset($_GET['deleteStudent'])) {
    session_start();
    $_SESSION['id_to_delete'] = $_GET['deleteStudent'];
    header('Location: deleted_students.php');
}

// Fetch student data from the database
if(isset($_POST['search'])){
    $filter = $_POST['filter'];
    $term = $_POST['term'];
    
    // Handle the "All" case separately
    if ($filter === 'All') {
        $query9 = "SELECT * FROM student";
    } elseif ($filter && $term) {
        // Construct the query normally for other filter options
        $query9 = "SELECT * FROM student WHERE $filter = '$term'";
    }
    $result9 = mysqli_query($conn, $query9);
} else {
    // If search not performed, fetch all students
    $query9 = "SELECT * FROM student";
    $result9 = mysqli_query($conn, $query9);
}
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
            width: auto;
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

        #add {
            background: blue;
            margin-right: 10%;
            border: none;
            border-radius: 5%;
            color: white;
            padding: 10px;
            cursor: pointer;
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
    <form method="post" action="EditStudents.php">
        <p style="color: blue;">Based on:</p>
        <select class="filter-select" name="filter">
            <option value="All">All</option>
            <option value="student_id">Student ID</option>
            <option value="email">Email ID</option>
            <option value="name">Name</option>
            <option value="indexnumber">Index Number</option>
            <option value="classroom_id">Classroom Id</option>
            <option value="form">Form</option>
        </select>
        <input class="search-input" type="text" name="term" placeholder="Enter search term">
        <button class="search-btn" type="submit" name="search">Search</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Student Email</th>
                <th>Gender</th>
                <th>KCPE Index Number</th>
                <th>Classroom ID</th>
                <th>Form</th>
                <th>Date Admitted</th>
                <th>DOB</th>
                <th>Dormitory</th>
                <th>Student Token</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result9) > 0) {
                while ($row9 = mysqli_fetch_assoc($result9)) {
                    echo "<tr>";
                    echo "<td style='color:orange;'>" . $row9['student_id'] . "</td>";
                    echo "<td>" . $row9['name'] . "</td>";
                    echo "<td style='color:blue;'>" . $row9['email'] . "</td>";
                    echo "<td style='color:green;'>" . $row9['gender'] . "</td>";
                    echo "<td style='color:black;'>" . $row9['indexnumber'] . "</td>";
                    echo "<td style='color:orange;'>" . $row9['classroom_id'] . "</td>";
                    echo "<td style='color:red;'>" . $row9['form'] . "</td>";
                    echo "<td style='color:grey;'>" . $row9['date_admitted'] . "</td>";
                    echo "<td style='color:blue;'>" . $row9['DOB'] . "</td>";
                    echo "<td style='color:black;'>" . $row9['dormitory'] . "</td>";
                    echo "<td style='color:green;'>" . $row9['token'] . "</td>";
                    echo "<td>";
                    echo "<a style='background-color:yellow; color:black;' href='?editStudent=" . $row9['student_id'] . "'>Edit</a> | ";
                    echo "<a style='background-color:red; color:white;' href='?deleteStudent=" . $row9['student_id'] . "' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr style='color:red;'><td colspan='12'>No students found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <button id="add" onclick="window.location.href='student.php'">Add New Student</button>
    <footer>
        <p style="color: blue;">Makueni Boys Admin Panel - Edit Students</p>
        <p style="color: orange;">&copy KEliFE 2024</p>
    </footer>
</body>
</html>
