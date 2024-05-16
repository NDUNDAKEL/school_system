

<?php
include('Database Operations/connect.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

    $query_edit = "SELECT * FROM student WHERE student_id = '$id'";
    $result_edit = mysqli_query($conn,$query_edit);

    if($row=mysqli_fetch_assoc($result_edit)){
        $student_id=$row['student_id'];
        $email=$row['email'];
        $name=$row['name'];
        $gender=$row['gender'];
        $indexnumber=$row['indexnumber'];
        $classroomId=$row['classroom_id'];
        $form=$row['form'];
        $dormitory=$row['dormitory'];
        $DOB=$row['DOB'];
    }
$query_dormitory = "SELECT * FROM dormitory";
$result_dormitory = mysqli_query($conn, $query_dormitory);
$query_classroom = "SELECT * FROM classroom";
$result_classroom = mysqli_query($conn, $query_classroom);

$query_form = "SELECT * FROM form";
$result_form = mysqli_query($conn, $query_form);

$message = "";
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
     
        .form{
            display: inline-block;
            height: auto;
            color: white;
            width: 100%;
            height:auto;
            margin-left:50%;
            margin-top:10%;
            padding: 10px; 
            background-color:grey;
            border-radius: 7px;
        }
        footer{
            color:rgb(255, 0, 191);
            margin: 0%;
            height: auto;
        }
        button{
            background: black;
            font-weight: bolder;
            color: white;
            border-radius: 5px;
            width:auto;
            height: 30px;
            border: none;
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
    
        label{
            color:white;
            font-weight:bolder;
        }
        #message{
            padding-top:2px;
            background:white;
            align-items:center;
        }
        #gender>label{
            color:blue;
        }
        #gender>input{
            height:20px;
            cursor:pointer;
        }
        #gender{
            display:flex;
            width:20%;
            align-items:center;
            margin-right:40%;
            
        }
        #heading{
             display:block;
            
        }
        select{
            color:blue;
        }
        #heading>img{
            height:70px;
         
        
        }
    
    </style>
</head>
<body>
 
  
    </center>
    <center>
    
            <div class="form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <!-- Form fields with PHP values -->
                    <img style='border-radius:9px;' src="./makuenilogo.png" alt="school logo"><br>
                    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                    <label for="student_name">Student name</label>
                    <input readonly required type="text" name="student_name" value="<?php echo $name; ?>" placeholder="Enter the student name"><br>
                    <label for="email">Student email</label>
                    <input readonly required type="email" name="email" value="<?php echo $email; ?>" placeholder="Enter your email"><br>
                    <label>Student gender:</label>
                    <div id='gender'>
                    <input disabled type="radio" id="male" name="gender" value="male" <?php if($gender == 'male') echo "checked"; ?>>
                    <label for="male">Male</label>
                    <input disabled type="radio" id="female" name="gender" value="female" <?php if($gender == 'female') echo "checked"; ?>>
                    <label for="female">Female</label>
                    <input   disabled type="radio" id="other" name="gender" value="other" <?php if($gender == 'other') echo "checked"; ?>>
                    <label for="other">Other</label><br>
    </div>
                    <label for="index">Student KCPE index number</label>
                    <input readonly required type="number" name="index" value="<?php echo $indexnumber; ?>" placeholder="Enter your KCPE index number"><br>
                    <!-- Form Category Selection -->
                    <label for="form_category">Student Form</label><br>
                    <select disabled id="form_category" name="form_category">
                        <?php 
                        while ($row_form = mysqli_fetch_assoc($result_form)) { ?>
                              <option value="<?php echo $row_form['form_name']; ?>" <?php if($form == $row_form['form_name']) echo "selected"; ?>><?php echo $row_form['form_name']; ?></option>
                        <?php } ?>
                    </select><br>
                    <!-- Classroom Selection -->
                    <label for="classroom">Student Classroom:</label><br>
                    <select disabled id="classroom" name="classroom">
                        <?php while ($row_class = mysqli_fetch_assoc($result_classroom)) { ?>
                            <option value="<?php echo $row_class['classroom_id']; ?>" <?php if($classroomId == $row_class['classroom_id']) echo "selected"; ?>><?php echo $row_class['classroom_id']; ?></option>
                        <?php } ?>
                    </select><br>
                    <!-- Dormitory Selection -->
                    <label for="dormitory">Student Dormitory:</label><br>
                    <select disabled id="dormitory" name="dormitory">
                        <?php while ($row_dormitory = mysqli_fetch_assoc($result_dormitory)) { ?>
                            <option value="<?php echo $row_dormitory['dormitory_id']; ?>" <?php if($dormitory == $row_dormitory['dormitory_id']) echo "selected"; ?>><?php echo $row_dormitory['dormitory_id']; ?></option>
                        <?php } ?>
                    </select><br>
                    <label for="DOB">Date of birth</label>
                    <input readonly required type="date" name="DOB" value="<?php echo $DOB; ?>" placeholder="Enter the student's DOB"><br>

                   
                </form>
                <div id="message">
                    <?php echo $message; ?>
                </div>
            
        </div>
    </center>
  
</body>
</html>
