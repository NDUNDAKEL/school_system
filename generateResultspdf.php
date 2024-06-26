<?php
session_start();
include ('Database Operations/connect.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION["schoolID"])) {
    $id = $_SESSION["schoolID"];
    $id = mysqli_real_escape_string($conn, $id);
} elseif (isset($_SESSION['parent'])) {
    $id = $_SESSION['parent'];
} else {
    $id = $_SESSION["schoolID"];
}

require __DIR__ . "/vendor/autoload.php";
use Dompdf\Dompdf;

// Function to convert image to base64
function base64_encode_image($image_path) {
    if (file_exists($image_path)) {
        $image_type = pathinfo($image_path, PATHINFO_EXTENSION);
        $image_data = file_get_contents($image_path);
        $base64_image = 'data:image/' . $image_type . ';base64,' . base64_encode($image_data);
        return $base64_image;
    } else {
        return false;
    }
}

$image_path = 'makuenilogo.jpeg'; // Update this path to your image path
$base64_image = base64_encode_image($image_path);
if (!$base64_image) {
    die("Error: Logo image not found.");
}

$marks = 0;
$total_subjects = 0;
$subjects = [];

$query9 = "SELECT * FROM subjects_taken WHERE student_id = '$id'";
$result9 = mysqli_query($conn, $query9);
if (!$result9) {
    die("Error: Failed to execute query: " . mysqli_error($conn));
}

$html = "<html><head><style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
            height: auto;
        }
        .header h2, .header h3 {
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        .info {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .info h4, .info p {
            margin: 0 0 10px 0;
        }
        .info h4 {
            color: #4CAF50;
        }
        .info p span {
            font-weight: bold;
        }
        .warning {
            color: red;
            font-weight: bold;
        }
        </style></head><body>";

$student_name = "N/A";
$form = "N/A";
$term = "N/A";

if (mysqli_num_rows($result9) > 0) {
    while ($row9 = mysqli_fetch_assoc($result9)) {
        $subjects[] = $row9;
    }
    
    usort($subjects, function($a, $b) {
        return $b['mark'] <=> $a['mark'];
    });
    
    $student_id = $subjects[0]['student_id'];
    $query7 = "SELECT * FROM student WHERE student_id = '$student_id'";
    $result7 = mysqli_query($conn, $query7);
    if (!$result7) {
        die("Error: Failed to execute query: " . mysqli_error($conn));
    }

    if ($row7 = mysqli_fetch_assoc($result7)) {
        $student_name = $row7['name'];
    }

    $form = $subjects[0]['form'];
    $term = $subjects[0]['term'];

    $html .= "<div class='header'>
                <img src='{$base64_image}' alt='School Logo'>
                <h2>Results for {$student_name}</h2>
                <h3>Form: {$form}, Term: {$term}</h3>
              </div>";

    $html .= "
    <table>
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Name</th>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Form</th>
                <th>Term</th>
                <th>Marks</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>";

    foreach ($subjects as $row9) {
        $marks += $row9['mark'];
        $total_subjects += 1;

        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($row9['Subect_id'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($row9['subject_name'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($row9['student_id'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($student_name) . '</td>';
        $html .= '<td>' . htmlspecialchars($row9['form'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($row9['term'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($row9['mark'] ?? '') . '</td>';
        $html .= '<td>' . htmlspecialchars($row9['grade'] ?? '') . '</td>';
        $html .= '</tr>';

        if ($row9['mark'] < 60) {
            $html .= '<div class="warning"><p>Spend more time on subject ID: ' . htmlspecialchars($row9['Subect_id'] ?? '') . '</p></div>';
        }
    }

    $html .= "</tbody></table>";
} else {
    $html .= "<p style='color:red;'>No subjects found.</p>";
}

if ($total_subjects > 0) {
    $mean = $marks / $total_subjects;
    if ($mean >= 70 && $mean <= 100) {
        $meangrade = 'A';
    } elseif ($mean >= 60 && $mean <= 69.99) {
        $meangrade = 'B';
    } elseif ($mean >= 50 && $mean <= 59.99) {
        $meangrade = 'C';
    } elseif ($mean >= 40 && $mean <= 49.99) {
        $meangrade = 'D';
    } else {
        $meangrade = 'F';
    }
} else {
    $mean = 0;
    $meangrade = 'N/A';
}

$queryT = "SELECT * FROM class_teachers WHERE class_id = '1E'";
$resultsT = mysqli_query($conn, $queryT);
if (!$resultsT) {
    die("Error: Failed to execute query: " . mysqli_error($conn));
}
$teacher_name = $teacher_email = $teacher_number = "";

if ($rowt = mysqli_fetch_assoc($resultsT)) {
    $teacher_idT = $rowt['classteacher_id'];

    $queryTs = "SELECT * FROM teacher WHERE teacher_id= '{$teacher_idT}'";
    $resultsTs = mysqli_query($conn, $queryTs);
    if (!$resultsTs) {
        die("Error: Failed to execute query: " . mysqli_error($conn));
    }

    if ($rowts = mysqli_fetch_assoc($resultsTs)) {
        $teacher_name = $rowts['name'];
        $teacher_email = $rowts['email'];
        $teacher_number = $rowts['phone_number'];
    }
}

$html .= "<div class='info'>
    <h4>{$form} {$term} Results</h4>
    <p>Average grade is <span style='color:blue;'>{$meangrade}</span> with a mean score of <span style='color:red;'>{$mean}</span></p>
    <br>
    <p>
    Class Teacher: <span style='color:blue;'>{$teacher_name}</span> 
    | Phone: <span><a href='tel:{$teacher_number}' style='color:blue;'>{$teacher_number}</a></span> 
    | Email: <span><a href='mailto:{$teacher_email}' style='color:green;'>{$teacher_email}</a></span>
    </p>
</div>";

$html .= "</body></html>";

try {
    $dompdf = new Dompdf(['chroot' => __DIR__]);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->addInfo('Title', 'Student Results');
    $dompdf->loadHtml($html);
    $dompdf->render();
    $streamName = "ADM $id $form $term Results";
    $dompdf->stream($streamName, array('Attachment' => 0));
} catch (Exception $e) {
    die('Error loading PDF: ' . $e->getMessage());
}
?>
