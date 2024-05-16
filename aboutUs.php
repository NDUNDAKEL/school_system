<?php
$path="Database Operations/login1.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="aboutUs.css"/>
</head>
<body>
    <header>
      <div class="menu-toggle">&#9776;</div>
         <img src="makuenilogo.png" alt="school logo"> 
      <nav>
        <a id="color1" onclick="showAdmin(),showColor1()" href="#" >Administration</a>
        <a id="color2" onclick="showDepartments(),showColor2()" href="#">Departments</a>
        <a id="color3"onclick="showActivities(),showColor3()" href="#" >Sports and activities</a>
        <a id="color4" onclick="showNonTS(),showColor4()" href="#" >Non-teaching Staff</a>
        <a id="color5" onclick="showNews(),showColor5()" href="#" >News</a> 
        <a href="<?php echo $path; ?>" style="color:lightgreen; font-size:bolder">Student login</a>
        </nav>
    </header>
    <main>
        <div id="content">
           <img src="schoolpic1.jpeg" alt="school picture" style="height: auto; width:70%">
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatum consequatur vero beatae laborum voluptates mollitia inventore, officiis facilis, quo fuga illum, voluptas veritatis! Exercitationem modi voluptatum alias animi minus explicabo!</p>
        </div>
         <div class="container" id="administration">
               <div id="links">
                <a onclick='principal()' href="#">School Principal</a>
                <a onclick="deputy()" href="#">School Deputy Principals</a>
                <a onclick="teachers()" href="#">Teachers</a>
                <a onclick="staff()" href="#">Staff and Non Teaching Staff</a>
        </div>
        </div>
        <div class="content">
         <div id="adminDisplay">
            <p>Welcome to the Admin Content</p>
         </div>
            <div id="principal">
               <p>School principal</p>
            </div>
            <div id="Dprincipal">
               <p>School Deputy principal</p>
            </div>
            <div id="Teachers">
               <p>Teachers </p>
            </div>
            <div id="staffs">
               <p>Staffs and non teaching staffs</p>
            </div>
         </div>
        <div class="container" id="Non-teaching">
               <div id="links">
                <a onclick="showWashrooms()" href="#">Washrooms and Cleaners</a>
                <a onclick="showSecurity()" href="#">Security</a>
                <a onclick="showKitchen()" href="#">Kitchen</a>
                <a onclick="showDrivers()" href="#">Drivers</a>
            </div>
            </div>
        <div class="content">
         <div id="NonteachingDisplay">
            <p>Welcome to the Non-teaching Content</p>
         </div>
           <div id="cleaners">
            <p>The cleaners</p>
           </div>
           <div id="security">
            <p>Security</p>
           </div>
           <div id="kitchen">
            <p>Kitchen</p>
           </div>
           <div id="drivers">
            <p>Drivers</p>
           </div>
         </div>
        <div class="container" id="Activities">
            <div id="links">
                <a onclick="clubs()" href="#">Clubs and societies</a>
                <a onclick="Football()" href="#">Football</a>
                <a onclick="Hockey()" href="#">Hockey</a>
                <!-- <a onclick="basketball()" href="#">BasketBall</a> -->
                <a onclick="rugby()" href="#">Rugby</a>
                <a onclick="Tt()" href="#">Table Tennis</a>
                <a onclick="Badminton()" href="#">Badminnton</a>
            </div>
            </div>
            <div class="content">
               <div id="ActivitiesDisplay">
                  <p>Welcome to the Activities Content</p>
               </div>
            <div id="Clubs">
                <p>This is the Clubs and activities department</p>
             </div>
             <div id="football">
                <p>Meet our football team</p>
             </div>
             <div id="hockey">
                <p>This is our hockey department</p>
             </div>
             <!-- <div id="basketball">
                <p>This is our basketball team</p>
             </div> -->
             <div id="Rugby">
                <p>This is our Rugby team</p>
             </div>
             <div id="TT">
                <p>This is our Table tennis team</p>
             </div>
             <div id="badminton">
                <p>This is our badminton team</p>
             </div>
        </div>
        <div class="container"id="News">
         <img src="schoolpic1.jpeg" alt="school picture" style="height: auto; width:70%">
         <p id="newsText">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatum consequatur vero beatae laborum voluptates mollitia inventore, officiis facilis, quo fuga illum, voluptas veritatis! Exercitationem modi voluptatum alias animi minus explicabo!</p>
   
        </div>
    </div>
        <div class="container" id="departments">
            <div id="links">
                <a onclick="sciences()" href="#">Science Department</a>
                <a onclick="language()"href="#">Languages Department</a>
                <a onclick="technical()" href="#">Technicals Department</a>
                <a onclick="math()"href="#">Math Department</a>
            </div>
            </div>
            <div class="content">
               <div id="DepartmentDisplay">
                  <p>This is the departments content</p>
               </div>
         <div id="science">
            <p>This is the science department</p>
         </div>
         <div id="languages">
            <p>This is the languages department</p>
         </div>
         <div id="technicals">
            <p>This is the Technicals department</p>
         </div>
         <div id="Math">
            <p>This is the Math department</p>
        </div>
         </div>
    </main>
<footer>
<center>
   <p style="color: blue;">Makueni Boys High School</p>
    <h2><span>Like a tree knowledge grows</span></h2>
    <p style="color:white;">School Space &copy 2024</p>
</center>
</footer>
<script src="aboutUs.js"></script>
</body>
</html>