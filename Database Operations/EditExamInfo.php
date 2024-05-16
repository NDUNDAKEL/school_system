<?php
include("connect.php");

session_start();

if(isset($_SESSION['exam_edit'])){
    $id_to_edit = $_SESSION['exam_edit'];
    $queryS = "SELECT * FROM exam WHERE exam_id = '$id_to_edit'";
    $resultS = mysqli_query($conn, $queryS);

    if($rowS = mysqli_fetch_assoc($resultS)){
        $exam_idS = $rowS['exam_id'];
        $exam_nameS = $rowS['exam_name'];
        $year_doneS = $rowS['year_done'];
        $term_doneS = $rowS['term_done'];
        $form_which_didS = $rowS['form_which_did'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_id = filter_input(INPUT_POST, "exam_id", FILTER_SANITIZE_SPECIAL_CHARS);
    $exam_name = filter_input(INPUT_POST, "exam_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $form_which_did = filter_input(INPUT_POST, "form_which_did", FILTER_SANITIZE_SPECIAL_CHARS);
    $year_done = filter_input(INPUT_POST, "year_done", FILTER_SANITIZE_NUMBER_INT);
    $term_done = filter_input(INPUT_POST, "term_done", FILTER_SANITIZE_SPECIAL_CHARS);

    if (!empty($exam_id) && !empty($exam_name) && !empty($form_which_did) && !empty($year_done) && !empty($term_done)) {
        $sql = "UPDATE exam SET exam_id ='$exam_id', exam_name ='$exam_name', year_done='$year_done', term_done ='$term_done', form_which_did='$form_which_did' WHERE exam_id ='$id_to_edit'";
        try {
            mysqli_query($conn, $sql);
            echo "<script>alert('Exam Edited Successfully');</script>";

            // Updating the displayed values
            $exam_idS = $exam_id;
            $exam_nameS = $exam_name;
            $year_doneS = $year_done;
            $term_doneS = $term_done;
            $form_which_didS = $form_which_did;

            unset($_SESSION['exam_edit']);
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('Error Editing the exam. Make sure the exam id is unique and not used in the database for another exam');</script>";
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
    <title>Edit Exam</title>
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
                    <input required type="text" name="exam_id" value="<?php echo $exam_idS ?>" placeholder="Enter the exam id"><br>
                    <label for="subject_namae">Enter the exam name</label>
                    <input required type="text" name="exam_name" value="<?php echo $exam_nameS ?>" placeholder="Enter the exam name"><br>
                    <label for="year">Year:</label>
                    <input type="number" id="year" name="year_done" value="<?php echo $year_doneS ?>" placeholder="Enter year" required>
                    <label>Choose the Term </label><br>
                    <select name="term_done">
                    <?php
                    $query = "SELECT * FROM terms";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($row['term'] == $term_doneS) {
                            echo "<option value='{$row['term']}' selected>{$row['term']}</option>";
                        } else {
                            echo "<option value='{$row['term']}'>{$row['term']}</option>";
                        }
                    }
                    ?>
                    </select><br>
                    <label>Choose Form</label><br>
                    <select name="form_which_did">
                    <?php
                    $query7 = "SELECT * FROM form";
                    $result7 = mysqli_query($conn, $query7);
                    while ($row7 = mysqli_fetch_assoc($result7)) {
                        if ($row7['form_name'] == $form_which_didS) {
                            echo "<option value='{$row7['form_name']}' selected>{$row7['form_name']}</option>";
                        } else {
                            echo "<option value='{$row7['form_name']}'>{$row7['form_name']}</option>";
                        }
                    }
                    ?>
                    </select><br>

                    <button type="submit" name="submit">Edit Exam</button>
                    <button onclick="window.location.href='editExams.php'" id="view" type="button" name="View">View Exams</button>
                </form>
            </div>
        </div>
    </center>
    <footer>
        <center>
            <h2 style="color:green;"><span>Like a tree knowledge grows</span></h2>
            <p>Powered by School Space &copy 2024</p>
        </center>
    </footer>
</body>
</html>
