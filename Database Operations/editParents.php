<?php
include("connect.php");
session_start();

if (isset($_SESSION['parent_to_edit'])) {
    $id_to_edit = $_SESSION['parent_to_edit'];
    $queryS = "SELECT * FROM parents WHERE parent_id = '$id_to_edit'";
    $resultS = mysqli_query($conn, $queryS);

    if ($rowS = mysqli_fetch_assoc($resultS)) {
        $nameS = $rowS['name'];
        $student_idS = $rowS['student_id'];
        $emailS = $rowS['email'];
        $adressS = $rowS['adress'];
        $phone_numberS = $rowS['phone_number']; // Correct column name
        $nationalIDS = $rowS['nationalID'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
    $student_id = filter_input(INPUT_POST, "student_id", FILTER_SANITIZE_NUMBER_INT);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $adress = filter_input(INPUT_POST, "adress", FILTER_SANITIZE_SPECIAL_CHARS);
    $phone_number = filter_input(INPUT_POST, "phone_number", FILTER_SANITIZE_NUMBER_INT);
    $nationalID = filter_input(INPUT_POST, "nationalID", FILTER_SANITIZE_NUMBER_INT);

    if (!empty($name) && !empty($student_id) && !empty($email) && !empty($adress) && !empty($phone_number) && !empty($nationalID)) {
        $sql = "UPDATE parents SET name ='$name', student_id ='$student_id', email='$email', adress='$adress', phone_number='$phone_number', nationalID='$nationalID' WHERE parent_id ='$id_to_edit'";
        try {
            mysqli_query($conn, $sql);
            echo "<script>alert('Parent information updated successfully!');</script>";

            // Clear session data
            unset($_SESSION['editparent']);
            session_destroy();
            header('Location: editParents.php'); // Adjust the redirection as necessary
        } catch (mysqli_sql_exception $e) {
            echo "<script>alert('Error updating parent information.');</script>";
        }
    } else {
        echo "<script>alert('Please fill all fields.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Parent</title>
    <style>
        body {
            background-color: aliceblue;
        }
        .form {
            display: inline-block;
            color: white;
            margin: 6%;
            padding: 10px;
            background-color: orange;
            border-radius: 7px;
        }
        footer {
            color: rgb(255, 0, 191);
        }
        button {
            background: green;
            font-weight: bolder;
            color: white;
            border-radius: 5px;
            height: 30px;
            border: none;
            cursor: pointer;
            margin: 20px;
        }
        #view {
            background-color: blue;
        }
        label {
            color: white;
        }
        input {
            width: 100%;
            height: 30px;
            border: none;
            background-color: aquamarine;
            border-radius: 5px;
        }
        .container {
            background-color: aliceblue;
        }
        a {
            background-color: blue;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <a href="viewparents.html">Back to School Page</a>
    <center>
        <div class="container">
            <div class="form">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <img src="../makuenilogo.png" alt="school logo"><br>
                    <label for="name">Name:</label>
                    <input required type="text" name="name" value="<?php echo $nameS; ?>" placeholder="Enter the name"><br>
                    
                    <label for="student_id">Student ID:</label>
                    <input required type="number" name="student_id" value="<?php echo $student_idS; ?>" placeholder="Enter the student ID"><br>
                    
                    <label for="email">Email:</label>
                    <input required type="email" name="email" value="<?php echo $emailS; ?>" placeholder="Enter the email"><br>
                    
                    <label for="adress">Address:</label>
                    <input required type="text" name="adress" value="<?php echo $adressS; ?>" placeholder="Enter the address"><br>
                    
                    <label for="phone_number">Phone Number:</label>
                    <input required type="number" name="phone_number" value="<?php echo $phone_numberS; ?>" placeholder="Enter the phone number"><br>
                    
                    <label for="nationalID">National ID:</label>
                    <input required type="number" name="nationalID" value="<?php echo $nationalIDS; ?>" placeholder="Enter the national ID"><br>

                    <button type="submit" name="submit">Edit Parent</button>
                    <button onclick="window.location.href='viewparents.php'" id="view" type="button">View Parents</button>
                </form>
            </div>
        </div>
    </center>
    <footer>
        <center>
            <h2 style="color: green;"><span>Like a tree knowledge grows</span></h2>
            <p>Powered by School Space &copy; 2024</p>
        </center>
    </footer>
</body>
</html>
