<?php
//  ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// Prevent caching
header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// Include database connection
include('Database Operations/connect.php');

// Set session lifetime to 2 hours (in seconds)
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
    header("Location: Database Operations/login1.php");
    exit();
}

// Logout if logout form submitted
if (isset($_POST['logout'])) {
    logout();
}

$session_message = "";

// Check if the user is logged in
if (isset($_SESSION["schoolID"])) {
    $session_message = "Log out";
    $id = $_SESSION["schoolID"];
    
    // Escape the variable to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $id);
    
    // Query to retrieve user data
    $query = "SELECT * FROM student WHERE student_id = '$id'";
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            echo "No student found with ID: $id";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Session variable 'schoolID' not set.";
    $session_message = "Login";
    // Redirect to the login page if not logged in
    header('Location: Database Operations/login1.php');
    exit(); // Make sure to exit after redirecting
}

// Prevent the page from being cached by the browser
header("Cache-Control: no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="ademics.css"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->

</head>
<style>
/* #loader {
  position: fixed;
  z-index: 9999;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
}

.loader-icon {
  font-size: 50px;
  color:orange;/* Adjust the size of the icon 
} */

    </style>

<body>
<!-- <div id="loader">
    <div class="loader-icon">
  <i class="fas fa-spinner fa-spin"></i>
  </div>
</div> -->


    <header style='background-color: grey;'>
      <div class="menu-toggle">&#9776;</div>
         <a href="aboutUs.php"><img href="aboutUs.php" style="height:40px; border-radius:50%;" src="makuenilogo.png" alt="school logo"> </a>
         <a href="aboutUs.php"> <p class="makueni"style="align-items:center; margin-left:5px; margin-top:3px; color:yellow; cursor:pointer;">About Makueni  </p></a>
      <nav style="padding: 10px; border:none;">
        <a id="color1" onclick="showAdmin(),showColor1()" href="#" >Academics</a>
        <a id="color2" onclick="showDepartments(),showColor2()" href="#">Class Teacher</a>
        <a id="color3"onclick="showActivities(),showColor3()" href="#" >Past papers</a>
        <a id="color4" onclick="showNonTS(),showColor4()" href="#" >Assignments</a>
        <a  style='color:yellow;' id="color5" onclick="showNews(),showColor5()" href="#" >Your settings</a>
        <div style="display: flex; flex-direction: row;">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input style="align-items:center; margin-right:10px; margin-top:5px; background:lightgreen; height:20px; color:white;" type="submit" name="logout" value="<?php echo $session_message; ?>">
    </form>
        <b><p style="color:white; font-size: small;">  <?php echo $row["name"]; ?>  <span style="color: red;">
        <?php echo
        "ADM : {$row['student_id']}"; ?></span></p> </b>
       
        <br>
       <a href="main.html"><img style="border-radius: 50%; height: 30px;" src="user.jpeg"></a>
       </div> 
        </nav>
    </header>
    <main>
        <div id="content">
           <img src="makueni1.jpeg" alt="school picture" style="height: 50%; width:100%">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatum consequatur vero beatae laborum voluptates mollitia inventore, officiis facilis, quo fuga illum, voluptas veritatis! Exercitationem modi voluptatum alias animi minus explicabo!</p>
        </div>
         <div class="container" id="administration">
               <div id="links">
               <a onclick="deputy()" href="#">Register Subjects <i style='color:white; margin-left:3px;' class="fas fa-book"></i></a>  
                <a onclick="staff()" href="#">Your Subjects   <i style='color:white; margin-left:3px;' class="fas fa-bookmark"></i></a>
                <a onclick='principal()' href="#">Results  <i class="fas fa-check-circle" style='color:white; margin-left:3px;'></i></a>
                <a onclick="teachers()" href="#">Comments  <i class="fas fa-comments" style='color:white; margin-left:3px;'></i></a>
               
            </div>
        </div>
    <div class='info' id="principal">
    <?php
    $query9 = "SELECT * FROM subjects_taken WHERE student_id = '$id'";
    $result9 = mysqli_query($conn, $query9);
    $makrs=0;
    $total_subjects=0;

  
    if ($result9 && mysqli_num_rows($result9) > 0) {
        echo "
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
                 
                </tr>
            </thead>
            <tbody>";

        while ($row9 = mysqli_fetch_assoc($result9)) {
            $student_id = $row9['student_id'];
            $subject_id = $row9['Subect_id'];
            $query7 = "SELECT * FROM student WHERE student_id = '$student_id'";
            $result7 = mysqli_query($conn, $query7);
            $student_name = "N/A";
            $marks +=$row9['mark'];
            $total_subjects +=1;
            $term=$row9['term'];
            $form=$row9['form'];

            if ($result7 && $row7 = mysqli_fetch_assoc($result7)) {
                $student_name = $row7['name'];
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
    
           
            echo '</tr>';
        }

        echo "</tbody></table>";
    } else {
        echo "<p style='color:red;'>No subjects found.</p>";
    }
    $meangrade='';
    $mean=$marks/$total_subjects;
    if ($mean >= 70 && $mean <= 100) {
        $meangrade= 'A';
    } elseif ($mean >= 60 && $mean <= 69) {
        $meangrade='B';
    } elseif ($mean >= 50 && $mean <= 59) {
        $meangrade= 'C';
    } elseif ($mean >= 40 && $mean <= 49) {
        $meangrade= 'D';
    } else {
        $meangrade='F';
    }
   
    ?>

    <?php 
    $queryT = "SELECT * FROM class_teachers WHERE class_id = '{$row['classroom_id']}'";
    $resultsT = mysqli_query($conn, $queryT);
    $teacher_name = $teacher_email = $teacher_number = "";

    if ($resultsT && $rowt = mysqli_fetch_assoc($resultsT)) {
        $teacher_idT = $rowt['classteacher_id'];

        $queryTs = "SELECT * FROM teacher WHERE teacher_id= '{$teacher_idT}'";
        $resultsTs = mysqli_query($conn, $queryTs);

        if ($resultsTs && $rowts = mysqli_fetch_assoc($resultsTs)) {
            $teacher_name = $rowts['name'];
            $teacher_email = $rowts['email'];
            $teacher_number = $rowts['phone_number'];
        }
    }
    ?>

    <div class='info' id="comment">
        <h4 style='color:green'><?php echo "{$form }{$term }"?>Results</h4>
        <p>Average grade is <span style="color:blue; font-weight: bolder;"><?php echo $meangrade ?></span> of <span style='color:red;'><?php echo $mean ?></span></p>
        <br>
        <p>Class Teacher <span style="color:blue;"><?php echo $teacher_name; ?></span> Phone Number <span style="font-weight:bold;"><a href="tel:<?php echo $teacher_number; ?>"><?php echo $teacher_number; ?></a></span> Gmail <span style="color: green;"><a style="color: green;" href="mailto:<?php echo $teacher_email; ?>"><?php echo $teacher_email; ?></a></span></p>
    </div>
</div>
                <div class='info' id="Dprincipal">
    <?php include "registerSubjects.php"; ?>
   
</div>
<div id="Teachers">
<?php
include('Database Operations/connect.php');
    $query9 = "SELECT * FROM subjects_taken WHERE student_id = '$id'";
    $result9 = mysqli_query($conn, $query9);
    $makrs=0;
    $total_subjects=0;

  
    if ($result9 && mysqli_num_rows($result9) > 0) {
        echo "
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
                    <th>Teacher Comments</th>
                 
                </tr>
            </thead>
            <tbody>";

        while ($row9 = mysqli_fetch_assoc($result9)) {
            $student_id = $row9['student_id'];
            $subject_id = $row9['Subect_id'];
            $query7 = "SELECT * FROM student WHERE student_id = '$student_id'";
            $result7 = mysqli_query($conn, $query7);
            $student_name = "N/A";
            $marks +=$row9['mark'];
            $total_subjects +=1;
            $term=$row9['term'];
            $form=$row9['form'];
            $total_subjects +=1;

            if ($result7 && $row7 = mysqli_fetch_assoc($result7)) {
                $student_name = $row7['name'];
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
            echo '<td style="color:grey;">' . $row9['comment'] . '</td>';
    
           
            echo '</tr>';
        }

        echo "</tbody></table>";
    } else {
        echo "<p style='color:red;'>No subjects found.</p>";
    }
    $meangrade='';
    $mean=$marks/$total_subjects;
    if ($mean >= 70 && $mean <= 100) {
        $meangrade= 'A';
    } elseif ($mean >= 60 && $mean <= 69) {
        $meangrade='B';
    } elseif ($mean >= 50 && $mean <= 59) {
        $meangrade= 'C';
    } elseif ($mean >= 40 && $mean <= 49) {
        $meangrade= 'D';
    } else {
        $meangrade='F';
    }
   
    ?>

    <?php 
    $queryT = "SELECT * FROM class_teachers WHERE class_id = '{$row['classroom_id']}'";
    $resultsT = mysqli_query($conn, $queryT);
    $teacher_name = $teacher_email = $teacher_number = "";

    if ($resultsT && $rowt = mysqli_fetch_assoc($resultsT)) {
        $teacher_idT = $rowt['classteacher_id'];

        $queryTs = "SELECT * FROM teacher WHERE teacher_id= '{$teacher_idT}'";
        $resultsTs = mysqli_query($conn, $queryTs);

        if ($resultsTs && $rowts = mysqli_fetch_assoc($resultsTs)) {
            $teacher_name = $rowts['name'];
            $teacher_email = $rowts['email'];
            $teacher_number = $rowts['phone_number'];
        }
    }
    ?>

    <div class='info' id="comment">
        <h4 style='color:green'><?php echo "{$form }{$term }"?>Results</h4>
        <p>Average grade is <span style="color:blue; font-weight: bolder;"><?php echo $meangrade ?></span> of <span style='color:red;'><?php echo $mean ?></span></p>
        <br>
        <p>Class Teacher <span style="color:blue;"><?php echo $teacher_name; ?></span> Phone Number <span style="font-weight:bold;"><a href="tel:<?php echo $teacher_number; ?>"><?php echo $teacher_number; ?></a></span> Gmail <span style="color: green;"><a style="color: green;" href="mailto:<?php echo $teacher_email; ?>"><?php echo $teacher_email; ?></a></span></p>
    </div>
</div>
<div id="staffs">
<?php include "subjects_taken.php"; ?>
</div>

            </div>
    
        <div class="container" id="Non-teaching">
               <div id="links">
                <a onclick="showWashrooms()" href="#">Download holiday assignments</a>
                <a onclick="showSecurity()" href="#">Submit your holiday assignment</a>
                <a onclick="showKitchen()" href="#">Teachers review</a>
                <a onclick="showDrivers()" href="#">Students review</a>
            </div>
                </div>
          <div class="info" >
           <div id="cleaners">
            <p>Download holiday assignment</p>
           </div>
           <div id="security">
            <p>Submit your work</p>
           </div>
           <div id="kitchen">
            <p>Teachers review on how you did your assignment</p>
           </div>
           <div id="drivers">
            <p>How was the holiday assignment to you?</p>
           </div>
        </div>
        
        <div class="container" id="Activities">
            <div id="links">
                <a onclick="clubs()" href="#">Kcse pastpapers</a>
                <a onclick="Football()" href="#">Exam pastpapers</a>
                <a onclick="Hockey()" href="#">Upload your pastpapers</a>
                <!-- <a onclick="basketball()" href="#"></a>
                <a onclick="rugby()" href="#">Rugby</a>
                <a onclick="Tt()" href="#">Table Tennis</a>
                <a onclick="Badminton()" href="#">Badminnton</a> -->
            </div>
                </div>
            <div class="info">
            <div id="Clubs">
               <center>
            <h1>Search for past papers</h1>
             </div>
             <div id="football">
                <p>Search exam papers of a particular subject based on date</p>
             </div>
               <div id="hockey">
                  <h1>Upload Documents</h1>
                  <input type="file" id="fileInput" accept=".doc, .docx, .pdf, .ppt, .pptx">
                  <button onclick="uploadFile()">Upload</button>
                </div>
                  <div id="status"></div>
               </div>
            
        
             <!-- <div id="basketball">
                <p>This is our basketball team</p>
             </div> -->
             <!-- <div id="Rugby">
                <p>This is our Rugby team</p>
             </div>
             <div id="TT">
                <p>This is our Table tennis team</p>
             </div>
             <div id="badminton">
                <p>This is our badminton team</p>
             </div> -->
    
    </div>
        <div class="container"id="News">
        <div onclick="color()" id="links">
                <a onclick="showData()" href="#">Show Student Info</a>
                <a onclick="showpassword()"href="#">Manage Passwords</a> 
            </div>
</div>
        <div class="info">
         <div id="data">
        <?php
        include('Database Operations/connect.php');
        include "information.php";
        ?>    
</div>
         <div id="password">
     <?php 
      include('Database Operations/connect.php');
include "changePasswords.php";
     
     ?>
         </div>
         </div>
        <div class="container" id="departments">
            <div onclick="color()" id="links">
                <a onclick="sciences()" href="#">Class performance</a>
                <a onclick="language()"href="#">Student performance Review</a>
                <a onclick="technical()" href="#">Parent Reviews</a>
                <a onclick="math()"href="#">Student review</a>
            </div>
            </div>
 <div class="info">
         <div id="science">
            <p>This is how the classs did.</p>
         </div>
         <div id="languages">
            <p>This is how your child did</p>
         </div>
         <div id="technicals">
            <p>Any comment on your child's result</p>
         </div>
         <div id="Math">
            <p>Comment on your performance</p>
         </div>  
        </div>
    </main>
<footer>
<center>
    <h2><span style="color:white ;font-weight:20; opacity:0.5;">Like a tree knowledge grows</span></h2>
    <p style="color:blue;">School Space &copy 2024</p>
</center>
</footer>
<script src='Academics.js'>
//  function showLoader() {
//         document.getElementById("loader").style.display = "block";
//     }

//     function hideLoader() {
//         document.getElementById("loader").style.display = "none";
//     }

//     window.addEventListener("load", function() {
//         hideLoader(); // Hide the loader when all content has been loaded
//     });

</script>

</body>
</html>