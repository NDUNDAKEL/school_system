<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body{
        background-color: aliceblue;
    }
    .form{
        display: inline-block;
        height: auto;
        margin: 6%;
        padding: 10px; 
        background-color:rgb(255, 98, 0);
        border-radius: 7px;
    }
    footer{
        color:blue;
        margin: 0%;
        height: auto;
    }
    button{
        background: blue;
        font-weight: bolder;
        color: white;
        border-radius: 5px;
        width:50px;
        height: 30px;
        border: none;
        cursor: pointer;
        margin:20px
       
    }
    label{
        color: blue;
    }
    input{
        width: 100%;
        background-color: white;
        border-radius: 5px;
        border: none;
        height: 30px;
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
<body>
    <a href="aboutUs.html">Back to School Page</a>
    <marquee width="60%" direction="left" height="100px">
        <h1>Makueni Boys School System..<span style="color: red;"> ADMIN LOGIN SECTION</span></h1>
    </marquee>
    <center>
        <div class="container">
    <div class="form">
    <form action="Post" method="">
        <img src="makuenilogo.png" alt="school logo"><br>
        <label for="teacher_id">Enter Admin ID</label>
        <input required type="number" name="teacher_id" placeholder="Enter your Teacher ID"><br>
        <label for="schoolID">Enter your password</label>
        <input id="pass" required type="password" name="schoolID" placeholder="Enter password" onclick="showPass()"><br>
        <button type="submit">Login</button>
    </form>
    <div>
    </div>
</center>
<footer>
    <center>
        <h2 style="color:green;"><span>Like a tree knowledge grows</span></h2>
        <p>Powered by School Space &copy 2024</p>
    </center>
    </footer>
</div>

<script>
 function showPass(){
const pass=document.getElementById('pass')

 }
</script>
</body>
</html>