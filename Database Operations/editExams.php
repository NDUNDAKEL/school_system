<?php
include("connect.php");

$filter = $_POST['filter'] ?? 'All';
$search = $_POST['search'] ?? '';
$term = filter_input(INPUT_POST, 'term', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($_GET['editExam'])){
    session_start();
    $_SESSION['exam_edit'] = $_GET['editExam'];
    header('Location:EditExamInfo.php');
}
elseif(isset($_GET['deleteExam'])){
    session_start();
    $id_to_delete = $_GET['deleteExam'];
    $queryS = "DELETE FROM exam WHERE exam_id = '$id_to_delete'";
    $resultS = mysqli_query($conn, $queryS);
    if($resultS){
        echo "<script>alert('Exam Deleted successfully!');</script>";
        // Destroy the session
        session_unset();
        session_destroy();
        header('location: editExams.php');
        exit();
    }
    else{
        echo "<script>alert('Error deleting Subject');</script>";
    }
}
// Fetch subject data from the database
$query = "SELECT * FROM exam";

if (!empty($search) && !empty($term)) {
    if ($filter != 'All') {
        $query .= " WHERE $filter = '$term'";
    }
}
$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Management</title>
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
            background: grey;
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
    <h1 style='color:red'>Exam Management</h1>
    <form method='POST' action='<?php $_SERVER['PHP_SELF']; ?>'>
    <div id="search-bar">
        <label for="search-input">Search by:</label>
        <input name='term' type="text" id="search-input" placeholder="Enter search term">
        <select name='filter' id="filter-select">
            <option value="All">All subjects</option>
            <option value="subject_code">Subject Code</option>
            <option value="name">Subject Name</option>
            <option value="teacher_id">Teacher ID</option>
            <!-- Add more options here if needed -->
        </select>
        <button type="submit" name="search">Search</button>
    </div>
    </form>
    <table>
        <thead>
            <tr>
                <th>Exam ID</th>
                <th>Exam Name</th>
                <th>Year done</th>
                <th>Term Done</th>
                <th>Form which Did The exam</th>
                <th>Ations to be done</th>
        
            </tr>
        </thead>
        <tbody>
            <!-- PHP code for populating table rows -->
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td style='color:orange;'>" . $row['exam_id'] . "</td>";
                echo "<td style='color:green;'>" . $row['exam_name']."</td>";
                echo "<td style='color:green;'>" . $row['year_done']."</td>";
                echo "<td style='color:green;'>" . $row['term_done']."</td>";
                echo "<td style='color:green;'>" . $row['form_which_did']."</td>";
                echo "<td>";
                echo " <a style='background-color:yellow; color:black;' href='?editExam=". $row['exam_id'] . "'>Edit</a> |  ";
                echo "<a style='background-color:red; color:white;' href='?deleteExam=".$row['exam_id'] . "' onclick='return confirm(\"Are you sure you want to delete this subject?\")'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr style='color:red;'><td colspan='4'>No Exams found.</td></tr>";
        }
        mysqli_close($conn);
        ?>
        </tbody>
    </table>
    <button id="add" onclick="window.location.href='subjects.php'">Add New Exam</button>
    <footer>
        <p style="color: blue;">Makueni Boys Admin Panel - Edit Subjects</p>
        <p style="color: orange;">&copy KEliFE 2024</p>
    </footer>
    
</body>
</html>
