<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_id = filter_input(INPUT_POST, "exam_id", FILTER_SANITIZE_SPECIAL_CHARS);
    $exam_name = filter_input(INPUT_POST, "exam_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $form_which_did = filter_input(INPUT_POST, "form_which_did", FILTER_SANITIZE_SPECIAL_CHARS);
    $year_done = filter_input(INPUT_POST, "year_done", FILTER_SANITIZE_NUMBER_INT);
    $term_done = filter_input(INPUT_POST, "term_done", FILTER_SANITIZE_SPECIAL_CHARS);


    if (!empty($exam_id) && !empty($exam_name) && !empty($form_which_did) && !empty($year_done) && !empty($term_done)) {
        $sql = "INSERT INTO exam (`exam_id`, `exam_name`, `year_done`,`term_done`, `form_which_did`) VALUES ('$exam_id', '$exam_name', '$year_done','$term_done','$form_which_did')";
        try {
            mysqli_query($conn, $sql);
            echo "<script>alert('Exam added successfully into the database!');</script>";
            //header('location:editSubjects.php');
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('Error adding the exam. Make sure the exam id is unique and not used in the database for another exam');</script>";
        }
    }
}

$query = "SELECT * FROM teacher";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-color: aliceblue;
        }
        .form{
            display: inline-block;
            height: auto;
            color: white;
            width: auto;
            height: auto;
            margin: 6%;
            padding: 10px; 
            background-color:orange;
            border-radius: 7px;
        }
        footer{
            color:rgb(255, 0, 191);
            margin: 0%;
            height: auto;
        }
        button{
            background: blue;
            font-weight: bolder;
            color: white;
            border-radius: 5px;
            width:auto;
            height: 30px;
            border: none;
            cursor: pointer;
            margin:20px;
        }
        #view{
            background-color:green;
        }
        label{
            color: blue;
        }
        input{
            width: 100%;
            height: 30px;
            border: none;
            font:bolder;
            background-color: aquamarine;
            border-radius: 5px;
        }
        p{
            cursor: pointer;
        }
        .container{
            background-color: aliceblue;
        }
        a{
            height: auto;
            width: auto;
            background-color:blue;
            color:white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
        }
        
    </style>
</head>
<body>
    <a href="aboutUs.html">Back to School Page</a>
    <center>
        <div class="container">
            <div class="form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <img src="../makuenilogo.png" alt="school logo"><br>
                    <label for="Subject ID">Exam ID</label>
                    <input required type="text" name="exam_id" placeholder="Enter the exam id"><br>
                    <label for="subject_namae">Enter the exam name</label>
                    <input required type="text" name="exam_name" placeholder="Enter the exam name"><br>
                    <label for="year">Year:</label>
                    <input type="number" id="year" name="year_done" placeholder="Enter year" required>
                    <label>Choose the Term </label><br>
                    <select name="term_done">
                    <?php
                    $query = "SELECT * FROM terms";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"{$row['term']}\"> {$row['term']}</option>";
                    }
                    ?>
                </select><br>
                <label>Choose Form</label><br>
                <select name="form_which_did">
                <?php
$query7 = "SELECT * FROM form";
$result7 = mysqli_query($conn, $query7);
while ($row7 = mysqli_fetch_assoc($result7)) {
    echo "<option value='{$row7['form_name']}'>{$row7['form_name']}</option>";
}
?>
                </select><br>

                    <button type="submit" name="submit">Add Exam</button>
                    <button onclick="window.location.href='editExams.php'" id="view" type="button" name="View">View Exams</button>
 </form>
            </div>
    </center>
<footer>
    <center>
        <h2 style="color:green;"><span>Like a tree knowledge grows</span></h2>
        <p>Powered by School Space &copy 2024</p>
    </center>
</footer>
</div>
</body>
</html>






