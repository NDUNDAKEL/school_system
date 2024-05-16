<?php
include("connect.php");

$filter = $_POST['filter'] ?? 'All';
$search = $_POST['search'] ?? '';
$term = filter_input(INPUT_POST, 'term', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($_GET['editSubject'])){
    session_start();
    $_SESSION['subject_edit'] = $_GET['editSubject'];
    header('Location: editSubjects_info.php');
}
elseif(isset($_GET['deleteSubject'])){
    session_start();
    $id_to_delete = $_GET['deleteSubject'];
    $queryS = "DELETE FROM subjects WHERE subject_id = '$id_to_delete'";
    $resultS = mysqli_query($conn, $queryS);
    if($resultS){
        echo "<script>alert('Subject Deleted successfully!');</script>";
        // Destroy the session
        session_unset();
        session_destroy();
        header('location: editSubjects.php');
        exit();
    }
    else{
        echo "<script>alert('Error deleting Subject');</script>";
    }
}
// Fetch subject data from the database
$query = "SELECT * FROM subjects";


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
    <h1 style='color:red'>Subject Management</h1>
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
                <th>Subject Code</th>
                <th>Name</th>
                <th>Teacher ID</th>
                <th>Form doing the Subject</th>
                <th>Term subject is done</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- PHP code for populating table rows -->
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td style='color:orange;'>" . $row['subject_id'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td style='color:green;'>" . $row['teacher_id']."</td>";
                echo "<td style='color:green;'>" . $row['form_doing']."</td>";
                echo "<td style='color:green;'>" . $row['term_done']."</td>";
                echo "<td>";
                echo "<a style='background-color:yellow; color:black;' href='?editSubject=". $row['subject_id'] . "'>Edit</a> | ";
                echo "<a style='background-color:red; color:white;' href='?deleteSubject=".$row['subject_id'] . "' onclick='return confirm(\"Are you sure you want to delete this subject?\")'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr style='color:red;'><td colspan='4'>No subjects found.</td></tr>";
        }
        mysqli_close($conn);
        ?>
        </tbody>
    </table>
    <button id="add" onclick="window.location.href='subjects.php'">Add New Subject</button>
    <footer>
        <p style="color: blue;">Makueni Boys Admin Panel - Edit Subjects</p>
        <p style="color: orange;">&copy KEliFE 2024</p>
    </footer>
    
</body>
</html>
