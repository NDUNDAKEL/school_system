<?php
include("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_code = filter_input(INPUT_POST, "subject_code", FILTER_SANITIZE_SPECIAL_CHARS);
    $subject_name = filter_input(INPUT_POST, "subject_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $form = filter_input(INPUT_POST, "form", FILTER_SANITIZE_SPECIAL_CHARS);
    $term = filter_input(INPUT_POST, "term", FILTER_SANITIZE_SPECIAL_CHARS);
    $teacher_id = filter_input(INPUT_POST, "teacher_id", FILTER_SANITIZE_NUMBER_INT);

    if (!empty($subject_name) && !empty($subject_code) && !empty($form) && !empty($term) && !empty($teacher_id)) {
        $sql = "INSERT INTO subjects (`subject_id`, `name`, `teacher_id`,`form_doing`,`term_done`) VALUES ('$subject_code', '$subject_name', '$teacher_id','$form','$term')";
        try {
            mysqli_query($conn, $sql);
            echo "<script>alert('Subject added successfully!');</script>";
            //header('location:editSubjects.php');
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('Error adding the subject. Make sure the subject code is unique');</script>";
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
            color: white;
        }
        input{
            width: 100%;
            height: 30px;
            border: none;
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
                    <label for="Subject ID">Enter the subject Code</label>
                    <input required type="text" name="subject_code" placeholder="Enter the subject code"><br>
                    <label for="subject_namae">Enter the subject name</label>
                    <input required type="text" name="subject_name" placeholder="Enter the subject name"><br>
                    <Label>Subject Teacher </label><br>
<select name="teacher_id">
    <?php
    $query = "SELECT * FROM teacher";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value=\"{$row['teacher_id']}\">  {$row['name']}</option>";
    }
    ?>
</select><br>
<Label>Form doing this subject </label><br>
<select name="form">
    <?php
    $query1 = "SELECT * FROM form";
    $result1 = mysqli_query($conn, $query1);
    while ($row1 = mysqli_fetch_assoc($result1)) {
        echo "<option value=\"{$row1['form_name']}\">  {$row1['form_name']}</option>";
    }
    ?>
</select><br>
<Label>Term Done </label><br>
<select name="term">
    <?php
    $query2 = "SELECT * FROM terms";
    $result2 = mysqli_query($conn, $query2);
    while ($row2 = mysqli_fetch_assoc($result2)) {
        echo "<option value=\"{$row2['term']}\"> <span style='color:red'>{$row2['term']}</span> {$row2['term']}</option>";
    }
    ?>
</select><br>

                    <button type="submit" name="submit">Add subject</button>
                    <button onclick="window.location.href='editSubjects.php'" id="view" type="button" name="View">View subjects</button>
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