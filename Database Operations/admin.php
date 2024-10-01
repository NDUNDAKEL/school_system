<?php
include('connect.php');
session_start();
if(isset($_SESSION['admin_id'])){
    $adminID=$_SESSION['admin_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
*{
    box-sizing: border-box;
}
html,body{
    margin: 10;
    padding: 10;
    background-color:whitesmoke;
    
}
body{
    display: flex;
    height:40px;
    min-height: 100vh;
    flex-direction: column;
}
main{
    flex: 1 0 auto;
}
header{
    display:flex;
    background-color: orange;
    justify-content: space-between;
    border-bottom: 1px solid black;
    color: white;
}
#logo1,#logo{
    height: 40px;
    width: 40px;
    border-radius: 50%;
}
footer{
    background-color:orange;
    color: white;
}
.left-nav{
  display:flex;
  justify-content: space-between;
  background-color:lightgreen;
  width: auto;
  height: 100%;
}
.left-nav>a{
    text-decoration: none;
    width: auto;
    color:black;

}
.dd-btn:hover{
    color:white;
}
.dd-btn:active{
    color:white;
}
.dd{
    position:relative;
    display: inline-block;
}
.dd-btn{
    padding:15px;
    text-align:center;
    background:lightgreen;
    border:none;
    width: 300px;
    cursor:pointer;
    color: blue;
}
dd-btn:hover{
    color:red;
}
.dd-content{
    position: absolute;
    width:100%;
    box-shadow: 0 18px 36px rgba(0,0,0,0.30),0 14px 11px rgba(0,0,0,0.2);
    height: 0px;
    transition: height 1s;
    overflow: scroll;
}
.dd:hover>.dd-content{
    height:150px
}
.dd-content>a{
    display: block;
    padding: 15px;
    text-decoration: none;
    background-color: orange;
    color: white;
  
}
.dd-content>a:hover{
    background-color: black;
    color: white;
}
.container{

    color:white;
    height:789px;
    width:100%;
}

    </style>
<body>
    <header>
        <p style="color:green;">WELCOME ADMIN <span style='color:blue'><?php echo $adminID ?><span></p>
        <p>MAKUENI BOYS HIGH SCHOOL ADMIN PAGE</p>
        <p style="color: green; background-color:white">Online</p> 
    </header>
     <main>
        <div class="left-nav"> 
            <div class="dd">
                <button class="dd-btn" style='color:blue'>Manage Teachers</button>
                <div class="dd-content">
                    <p style="color: green;">Scroll for options</p>
                    <a href="javascript:void(0)" onclick="loadContent('../teacher.php')">Manage teachers Information</a>
                    <a href="javascript:void(0)" onclick="loadContent('../addClassteacher.php')">Add Class Teacher</a>

                </div>
            </div>
            <div class="dd">
                <button onclick="toggleStudent()" class="dd-btn">Manage Students</button>
                <div class="dd-content">
                    <p style="color: green;">Scroll for options</p>
                    <a href="javascript:void(0)" onclick="loadContent('student.php')">Manage Students</a>
                    <a href="javascript:void(0)" onclick="loadContent('viewparents.php')">View Parents</a>
                </div>
            </div>
            <div class="dd">
                <button  class="dd-btn">Manage Subjects</button>
                <div class="dd-content">
                    <p style="color: green;">Scroll for options</p>
                    <a href="javascript:void(0)" onclick="loadContent('subjects.php')">Manage Subjects</a>
                </div>
            </div>
            <div class="dd">
                <button class="dd-btn">Manage Exams</button>
                <div class="dd-content">
                    <p style="color: green;">Scroll for options</p>
                    <a href="javascript:void(0)" onclick="loadContent('exam.php')">Manage Exams</a>
                </div>
            </div>
        </div>
     </main>
     <div class="container" id="contentArea">
        <!-- Content will be loaded here -->
     </div>
    <footer>
        <center>
            <p>Makueni Boys Administration Panel</p>
            <p>School space &copy 2024</p>
        </center>
    </footer> 
    <script>
        function toggleStudent() {
            const students = document.getElementById('students');
            students.style.display = (students.style.display === 'block') ? 'none' : 'block';
        }

        function loadContent(url) {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('contentArea').innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", url, true);
            xhr.send();
        }
    </script>
</body>
</html>
