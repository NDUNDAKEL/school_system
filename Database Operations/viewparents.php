<?php
include("connect.php");

$filter = $_POST['filter'] ?? 'All';
$search = $_POST['search'] ?? '';
$term = filter_input(INPUT_POST, 'term', FILTER_SANITIZE_SPECIAL_CHARS);

session_start();

if (isset($_GET['editparent'])) {
    $_SESSION['parent_to_edit'] = $_GET['editparent'];
    header('Location: editParents.php');
    exit();
} elseif (isset($_GET['deleteparent'])) {
    $id_to_delete = $_GET['deleteparent'];
    $delete = "DELETE FROM parents WHERE parent_id = '$id_to_delete'";
    $result_delete = mysqli_query($conn, $delete);

    if ($result_delete) {
        echo "<script>alert('Successfully deleted');</script>";
    } else {
        echo "<script>alert('Error deleting');</script>";
    }
}

// Fetch student data from the database
if(isset($_POST['search'])){
    $filter = $_POST['filter'];
    $term = $_POST['term'];
    
    // Handle the "All" case separately
    if ($filter === 'All') {
        $query9 = "SELECT * FROM parents";
    } elseif ($filter && $term) {
        // Construct the query normally for other filter options
        $query9 = "SELECT * FROM parents WHERE $filter = '$term'";
    }
    $result9 = mysqli_query($conn, $query9);
} else {
    // If search not performed, fetch all students
    $query9 = "SELECT * FROM parents";
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
<a  href='student.php' style='color:white; background-color:green;'>Back to add students</a>

    <h1 style='color:red'>View Parents</h1>
    <form method="post" action="viewparents.php">
        <p style="color: blue;">Based on:</p>
        <select class="filter-select" name="filter">
            <option value="All">All</option>
            <option value="parent_id">Student ID</option>
        </select>
        <input class="search-input" type="text" name="term" placeholder="Enter search term">
        <button class="search-btn" type="submit" name="search">Search</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Parent ID</th>
                <th>Parent Name</th>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Parent Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>National ID</th>
                <th>Token</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result9) > 0) {
                while ($row9 = mysqli_fetch_assoc($result9)) {
                    echo "<tr>";
                    echo "<td style='color:orange;'>" . $row9['parent_id'] . "</td>";
                    echo "<td>" . $row9['name'] . "</td>";
                    echo "<td style='color:blue;'>" . $row9['student_id'] . "</td>";
                    echo "<td style='color:green;'>" . $row9['name'] . "</td>";
                    echo "<td style='color:black;'>" . $row9['email'] . "</td>";
                    echo "<td style='color:orange;'>" . $row9['phone_number'] . "</td>";
                    echo "<td style='color:red;'>" . $row9['adress'] . "</td>";
                    echo "<td style='color:grey;'>" . $row9['nationalID'] . "</td>";
                    echo "<td style='color:green;'>" . $row9['token'] . "</td>";
                    echo "<td>";
                    echo " <a style='background-color:yellow; color:black;' href='?editparent=" . $row9['parent_id'] . "'>Edit</a> | ";
                    echo "<a style='background-color:red; color:white;' href='?deleteparent=" . $row9['parent_id'] . "' onclick='return confirm(\"Are you sure you want to delete this Parent?\")'>Delete</a>";
                    echo "<td>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr style='color:red;'><td colspan='12'>No students found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <footer>
        <p style="color: blue;">Makueni Boys Admin Panel - Edit Students</p>
        <p style="color: orange;">&copy KEliFE 2024</p>
    </footer>
</body>
</html>
