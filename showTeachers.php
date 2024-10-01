<?php
include('Database Operations/connect.php');

$filter = $_POST['filter'] ?? 'All';
$search = $_POST['search'] ?? '';
$term = filter_input(INPUT_POST, 'term', FILTER_SANITIZE_SPECIAL_CHARS);

if (isset($_GET['editTeacher'])) {
    session_start();
    $_SESSION['teacher_id_to_edit'] = $_GET['editTeacher'];
    header('Location:editTeacher.php');
    exit();
} elseif (isset($_GET['deleteTeacher'])) {
    session_start();
    $_SESSION['teacher_id_to_delete'] = $_GET['deleteTeacher'];
    header('Location: deleteTeacher.php');
}

// Fetch student data from the database
if(isset($_POST['search'])){
    $filter = $_POST['filter'];
    $term = $_POST['term'];
    
    // Handle the "All" case separately
    if ($filter === 'All') {
        $query9 = "SELECT * FROM teacher";
    } elseif ($filter && $term) {
        // Construct the query normally for other filter options
        $query9 = "SELECT * FROM teacher WHERE $filter = '$term'";
    }
    $result9 = mysqli_query($conn, $query9);
} else {
    // If search not performed, fetch all students
    $query9 = "SELECT * FROM teacher";
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
            background: green;
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
    <h1 style='color:red'>Teacher Management</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <p style="color: blue;">Based on:</p>
        <select class="filter-select" name="filter">
            <option value="All">All</option>
            <option value="teacher_id">Teacher ID</option>
            <option value="name">Name</option>
            <option value="national_id">National ID</option>
        </select>
        <input class="search-input" type="text" name="term" placeholder="Enter search term">
        <button class="search-btn" type="submit" name="search">Search</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Teacher ID</th>
                <th>Teacher Name</th>
                <th>National ID</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Token</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result9) > 0) {
                while ($row9 = mysqli_fetch_assoc($result9)) {
                    echo "<tr>";
                    echo "<td style='color:orange;'>" . $row9['teacher_id'] . "</td>";
                    echo "<td>" . $row9['name'] . "</td>";
                    echo "<td style='color:green;'>" . $row9['national_id'] . "</td>";
                    echo "<td style='color:black;'>" . $row9['email'] . "</td>";
                    echo "<td style='color:orange;'>" . $row9['phone_number'] . "</td>";
                    echo "<td style='color:red;'>" . $row9['token'] . "</td>";
                    echo "<td>";
                    echo "<a style='background-color:yellow; color:black;' href='?editTeacher=" . $row9['teacher_id'] . "'>Edit</a> | ";
                    echo "<a style='background-color:red; color:white;' href='?deleteTeacher=" . $row9['teacher_id'] . "' onclick='return confirm(\"Are you sure you want to delete this student?\")'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr style='color:red;'><td colspan='12'>No Teachers found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <button id="add" onclick="window.location.href='teacher.php'">Add New Teacher</button>

</body>
</html>
