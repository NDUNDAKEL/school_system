<?php
include("connect.php");
$id="";
$subject_code="";
$subject_name="";
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
            background-color:grey;
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
                <input type='hidden' value="<?php  echo $id?>"/>
                    <img src="../makuenilogo.png" alt="school logo"><br>
                    <label for="Subject ID">Change the subject Code</label>
                    <input required type="text" name="subject_code" value="<?php echo $subject_code; ?>"><br>
                    <label for="subject_namae">Change the subject name</label>
                    <input required type="text" name="subject_name" value="<?php echo $subject_name; ?>"><br>
                    <button type="submit" name="submit">Edit subject</button>
                    <button onclick="window.location.href='editSubjects.php;'" id="view" type="button" name="View">View subjects</button>
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

<?php


?>
