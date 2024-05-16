
<?php
include("connect.php");
session_start();

if(isset($_SESSION['subject_edit'])){
    $id_to_edit = $_SESSION['subject_edit'];
    $queryS = "SELECT * FROM subjects WHERE subject_id = '$id_to_edit'";
    $resultS = mysqli_query($conn, $queryS);

    if($rowS = mysqli_fetch_assoc($resultS)){
        $name = $rowS['name'];
        $subject_id = $rowS['subject_id'];
        $teacher_idS = $rowS['teacher_id'];
        $form = $rowS['form_doing'];
        $term = $rowS['term_done'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subject_code = filter_input(INPUT_POST, "subject_code", FILTER_SANITIZE_SPECIAL_CHARS);
    $subject_name = filter_input(INPUT_POST, "subject_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $term = filter_input(INPUT_POST, "term", FILTER_SANITIZE_SPECIAL_CHARS);
    $form = filter_input(INPUT_POST, "form", FILTER_SANITIZE_SPECIAL_CHARS);
    $teacher_id = filter_input(INPUT_POST, "teacher_id", FILTER_SANITIZE_NUMBER_INT);

    if (!empty($subject_name) && !empty($subject_code)) {
        $sql = "UPDATE subjects SET name ='$subject_name', teacher_id ='$teacher_id', subject_id ='$subject_code', form_doing='$form', term_done='$term' WHERE subject_id ='$id_to_edit'";
         try {
            mysqli_query($conn, $sql);
            echo "<script>alert('Subject Edited successfully!');</script>";
            
            // Set updated values to display in the form
            $name = $subject_name;
            $subject_id = $subject_code;
            $teacher_idS = $teacher_id;
            
            // Clear session data
            unset($_SESSION['subject_edit']);
            session_destroy();
            //header('location:editSubjects.php');
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('Error Editing the subject. Make sure the subject code is unique');</script>";
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
    <title>Edit Subject</title>
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
            background: green;
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
            background-color:blue;
        }
        label{
            color: white;
            /* font:sans-sarif; */
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
                    <input required type="text" name="subject_code" value="<?php echo $subject_id ?>" placeholder="Enter the subject code"><br>
                    <label for="subject_namae">Enter the subject name</label>
                    <input required type="text" name="subject_name" value="<?php echo $name ?>" placeholder="Enter the subject name"><br>
                    <Label>Subject Teacher </label><br>
                    <select name="teacher_id">
    <?php
    $query = "SELECT * FROM teacher";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $selected = ($row['teacher_id'] == $teacher_idS) ? 'selected' : '';
        echo "<option value=\"{$row['teacher_id']}\" $selected>  {$row['name']}</option>";
    }
    ?>
</select><br>
<Label>Form </label><br>
                    <select name="form">
    <?php
    $query1 = "SELECT * FROM form";
    $result1 = mysqli_query($conn, $query1);
    while ($row1= mysqli_fetch_assoc($result1)) {
        $selected1 = ($row1['form_name'] == $form) ? 'selected' : '';
        echo "<option value=\"{$row1['form_name']}\" $selected1> {$row1['form_name']}</option>";
    }
    ?>
</select><br>

<Label>Term The Subject is Done </label><br>
                    <select name="term">
    <?php
    $query2 = "SELECT * FROM terms";
    $result2 = mysqli_query($conn, $query2);
    while ($row2 = mysqli_fetch_assoc($result2)) {
        $selected2 = ($row2['term'] == $term) ? 'selected' : '';
        echo "<option value=\"{$row2['term']}\" $selected2>  {$row2['term']}</option>";
    }
    ?>
</select><br>




                    <button type="submit" name="submit">Edit Subject</button>
                    <button onclick="window.location.href='editSubjects.php'" id="view" type="button" name="View">View subjects</button>
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









