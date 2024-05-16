<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="adInfo.css">
</head>
<body>
    <header>
        <img id="logo1" src="makuenilogo.png" alt="school logo">
        <p style="color:white;">Welcome Admin</p>
        <p>Edit your details</p>
        <p style="color: green; background-color:white">Online</p>
        <img id="logo" src="makuenilogo.png" alt="admin-logo">   
    </header>
     <main>
        <div class="left-nav"> 
            <div class="dd">
                <button class="dd-btn">Manage Teachers</button>
                <div class="dd-content">
                    <p style="color: green;">Scroll for options</p>
                    <a href="javascript:void(0)" onclick="loadContent('../teacher.php')">Manage teachers Information</a>
                </div>
            </div>
            <div class="dd">
                <button onclick="toggleStudent()" class="dd-btn">Manage Students</button>
                <div class="dd-content">
                    <p style="color: green;">Scroll for options</p>
                    <a href="javascript:void(0)" onclick="loadContent('student.php')">Manage Students</a>
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
