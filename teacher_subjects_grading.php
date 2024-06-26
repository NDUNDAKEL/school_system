<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Prevent caching
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// Include database connection
include('Database Operations/connect.php');

// Set session lifetime to 2 hours
$session_lifetime = 7200; // 2 hours * 60 minutes * 60 seconds

// Set session cookie parameters
session_set_cookie_params($session_lifetime);
session_start();

// Function to logout
function logout() {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header("Location:teacher_account_login.php");
    exit();
}

// Logout if logout form submitted
if (isset($_POST['logout'])) {
    logout();
}

$messageR = "";

// Check if the user is logged in
if (isset($_SESSION["teacher_id"])) {
    $session_message = "Log out";
    $teacher_id = $_SESSION["teacher_id"];
    
    // Escape the variable to prevent SQL injection
    $teacher_id = mysqli_real_escape_string($conn, $teacher_id);
    
    // Query to retrieve teacher data
    $nipe = "SELECT * FROM teacher WHERE teacher_id = '$teacher_id'";
    $matokeo = mysqli_query($conn, $nipe);
    if ($ubao = mysqli_fetch_assoc($matokeo)) {
        $jina = $ubao['name'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Session variable 'teacher_id' not set.";
    $session_message = "Login";
    // Redirect to the login page if not logged in
    header('Location:teacher_subjects_grading.php');
    exit();
}

if (isset($_GET['add'])) {
    $_SESSION['addgrade'] = $_GET['add'];
    header('Location:Addgrades.php');
}

// Prevent the page from being cached by the browser
header("Cache-Control: no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Search and filter subjects taken
if (isset($_POST['search'])) {
    $filter = $_POST['filter'];
    $term = $_POST['term'];
    
    // Handle the "All" case separately
    if ($filter === 'All') {
        $query9 = "SELECT * FROM subjects_taken WHERE teacher_id ='$teacher_id'";
    } elseif ($filter && $term) {
        // Construct the query normally for other filter options
        $query9 = "SELECT * FROM subjects_taken WHERE $filter = '$term' AND teacher_id ='$teacher_id'";
    }
    $result9 = mysqli_query($conn, $query9);
} else {
    // If search not performed, fetch all subjects
    $query9 = "SELECT * FROM subjects_taken WHERE teacher_id ='$teacher_id'";
    $result9 = mysqli_query($conn, $query9);
}

// Fetch subjects taught by the teacher
$querySubjects = "SELECT * FROM subjects WHERE teacher_id = '$teacher_id'";
$resultSubjects = mysqli_query($conn, $querySubjects);

// Debugging: Check if the query executed correctly
if (!$resultSubjects) {
    echo "Error fetching subjects: " . mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: black;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links {
            display: flex;
            gap: 10px;
        }

        .nav-link {
            color: yellow;
            cursor: pointer;
            text-decoration: underline;
        }

        .logout-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-input {
            height: 30px;
            border-radius: 5px;
            padding: 5px;
            margin-right: 10px;
        }

        .filter-select {
            height: 30px;
            border-radius: 5px;
            margin-right: 10px;
        }

        .search-btn {
            background-color: black;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .register {
            margin: 0 auto;
            width: 70%;
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        th {
            background-color: orange;
            color: white;
        }

        .add-grade-btn {
            background-color: blue;
            color: white;
            text-decoration: none;
            cursor: pointer;
            width: 70px;
            height: 40px;
            width: auto;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h4>Teacher: <?php echo $jina; ?></h4>
            <div class="nav-links">
                <span id="add-grades-link" class="nav-link">Add Grades</span>
                <span id="subjects-link" class="nav-link">Subjects</span>
            </div>
            <form method="post" action="teacher_subjects_grading.php">
                <button class="logout-btn" name="logout">Log out</button>
            </form>
        </div>

        <div id="add-grades-section" class="hidden">
            <div class="search-container">
                <form method="post" action="teacher_subjects_grading.php">
                    <p style="color: blue;">Based on:</p>
                    <select class="filter-select" name="filter">
                        <option value="All">All</option>
                        <option value="student_id">Student ID</option>
                        <option value="Subect_id">Subject ID</option>
                        <option value="form">Form</option>
                        <option value="term">Term</option>
                    </select>
                    <input class="search-input" type="text" name="term" placeholder="Enter search term">
                    <button class="search-btn" name="search">Search</button>
                </form>
            </div>

            <div class="register">
                <table>
                    <thead>
                        <tr>
                            <th>Subject Code</th>
                            <th>Name</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Form doing the Subject</th>
                            <th>Term subject is done</th>
                            <th>Marks</th>
                            <th>Grade</th>
                            <th>Comment</th>
                            <th style="width: 70px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($result9) && mysqli_num_rows($result9) > 0) {
                            while ($row9 = mysqli_fetch_assoc($result9)) {
                                $student_id = $row9['student_id'];
                                $subject_id = $row9['Subect_id'];
                                $query7 = "SELECT * FROM student WHERE student_id = '$student_id'";
                                $result7 = mysqli_query($conn, $query7);
                                if ($row7 = mysqli_fetch_assoc($result7)) {
                                    $student_name = $row7['name'];
                                } else {
                                    $student_name = "N/A";
                                }
                                
                                echo '<tr>';
                                echo '<td style="color:orange;">' .  $row9['Subect_id'] . '</td>';
                                echo '<td>' . $row9['subject_name'] . '</td>';
                                echo '<td style="color:green;">' . $row9['student_id'] . '</td>';
                                echo '<td style="color:green;">' . $student_name . '</td>';
                                echo '<td style="color:green;">' . $row9['form'] . '</td>';
                                echo '<td style="color:grey;">' . $row9['term'] . '</td>';
                                echo '<td style="color:blue;">' . $row9['mark'] . '</td>';
                                echo '<td style="color:red;">' . $row9['grade'] . '</td>';
                                echo '<td style="color:green;">' . $row9['comment'] . '</td>';
                                echo '<td>';
                                echo '<form method="get">';
                                echo '<input type="hidden" name="subject_id" value="' . $row9['Subect_id'] . '">';
                                echo '<input type="hidden" name="student_id" value="' . $row9['student_id'] . '">';
                                echo "<button type='submit' name='add' value='" . $row9['Subect_id'] . ',' . $row9['student_id'] . "' class='add-grade-btn'>Add Grade</button>";
                                echo '</form>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo "<tr><td colspan='10' style='color:red;'>No subjects found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="subjects-section">
            <div class="register">
                <table>
                    <thead>
                        <tr>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Form Done</th>
                            <th>Term Done</th>
                            <th style="width: 70px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultSubjects && mysqli_num_rows($resultSubjects) > 0) {
                            while ($rowSubjects = mysqli_fetch_assoc($resultSubjects)) {
                                echo '<tr>';
                                echo '<td style="color:orange;">' . $rowSubjects['subject_id'] . '</td>';
                                echo '<td>' . $rowSubjects['name'] . '</td>';
                                echo '<td>' . $rowSubjects['form_doing'] . '</td>';
                                echo '<td>' . $rowSubjects['term_done'] . '</td>';
                                echo '<td>';
                                echo "<button class='add-grade-btn' onclick=\"loadAddGrades('" . $rowSubjects['subject_id'] . "');\">Add Grades</button>";
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo "<tr><td colspan='5' style='color:red;'>No subjects found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php echo $messageR; ?>
    </div>
    <script>
        function showSection(sectionId) {
            document.getElementById('add-grades-section').classList.add('hidden');
            document.getElementById('subjects-section').classList.add('hidden');
            document.getElementById(sectionId).classList.remove('hidden');
        }

        function loadAddGrades(subjectId) {
            document.querySelector('.filter-select').value = 'Subect_id';
            document.querySelector('.search-input').value = subjectId;
            document.querySelector('.search-btn').click();
            showSection('add-grades-section');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Show subjects section by default
            showSection('subjects-section');

            document.getElementById('add-grades-link').addEventListener('click', function() {
                showSection('add-grades-section');
            });

            document.getElementById('subjects-link').addEventListener('click', function() {
                showSection('subjects-section');
            });
        });
    </script>
</body>
</html>
